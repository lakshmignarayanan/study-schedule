<?php

namespace App\Services;
use App\Constants\HTTPConstant;
use App\Models\MySQL\ActivityModel;
use App\Helpers\Util;

class ScheduleService {

    private $result = [
        "code" => HTTPConstant::APPLICATION_ERROR,
        "data" => [],
        "error" => []
    ];
    const ENTITY = "schedule";
    private $time_period = 0;
    private $time_period_in_units = "";//week, month...
    private $available_time_in_minutes_per_unit = 0;
    private $average_course_duration = 0;
    
    private $incompleteActivities = [];
    private $activityModel;

    public function __construct() {
        $this->activityModel = new ActivityModel();
    }

    public function init($data) {
        if(isset($data["activities"])) {
            $this->activities = $data["activities"];
        }
        $this->setActivitiesData($data);
        $this->time_period = $data["time_period"]??3;
        $this->time_period_in_units = $data["time_period_in_units"]??"month"; //week, month...
        $this->available_time_in_minutes_per_unit = $data["available_time_in_minutes_per_unit"]??1200;
    }

    private function setActivitiesData($data = []) {
        if(!isset($data["activities"])) {
            $data = $this->activityModel->get();
        }
        $this->activities = $data["activities"]??[];
    }

    private function calculateAvailableTimePerUnit() {
        //max time required when activities not completed
        $this->incompleteActivities = array_filter($this->activities, function($activity) {
            return $activity["isComplete"] == false;
        });
        $durationsOfActivities = array_map(function($activity) {
            return $activity["durationMinutes"];
        }, $this->incompleteActivities);

        $total_required_minutes = array_sum($durationsOfActivities);
        $this->average_course_duration = $total_required_minutes / count($durationsOfActivities);
        
        $total_available_minutes = $this->available_time_in_minutes_per_unit * $this->time_period;
        $overflow_in_minutes = $total_required_minutes - $total_available_minutes;
        if($overflow_in_minutes > 0) {
            $overflow_per_unit = $overflow_in_minutes / $this->time_period;
            $this->available_time_in_minutes_per_unit = ceil($this->available_time_in_minutes_per_unit + $overflow_per_unit);
        }
    }

    public function calculate($show_completed_activities = false) {
        $this->calculateAvailableTimePerUnit();
        $result = [];
        $activities_list = $this->incompleteActivities;
        if($show_completed_activities) {
            $activities_list = $this->activities;
        }
        $current_schedule_unit = 1; $current_schedule_time = 0;
        foreach($activities_list as $activity) {
            if($current_schedule_time < $this->available_time_in_minutes_per_unit && 
                (
                    ($current_schedule_time + $activity["durationMinutes"] <= $this->available_time_in_minutes_per_unit)
                    || ($current_schedule_time <= $this->available_time_in_minutes_per_unit && $activity["durationMinutes"] >= $this->average_course_duration)
                )) {
                //add to current schedule
                if(!isset($result[$current_schedule_unit])) {
                    $result[$current_schedule_unit] = [
                        "name" => ucfirst($this->time_period_in_units." ".$current_schedule_unit),
                        "activities" => [],
                        "totalTimeInMinutes" => 0,
                        "totalTimeInWords" => "",
                    ];
                }
                $result[$current_schedule_unit]["activities"][] = $activity["name"];
                $current_schedule_time += $activity["durationMinutes"];
            } else {
                //calculate total time for past week
                $previous_schedule_time = Util::minutesToWordsConverter($current_schedule_time);
                $result[$current_schedule_unit]["totalTimeInMinutes"] = $current_schedule_time;
                $result[$current_schedule_unit]["totalTimeInWords"] = $previous_schedule_time;
                // increment for new schedule unit
                $current_schedule_unit++;
                $result[$current_schedule_unit] = [
                    "name" => ucfirst($this->time_period_in_units." ".$current_schedule_unit),
                    "activities" => [$activity["name"]],
                    "totalTimeInMinutes" => 0,
                    "totalTimeInWords" => "",
                ];
                $current_schedule_time = $activity["durationMinutes"];
            }
        }
        $this->result["code"] = HTTPConstant::OK;
        $this->result["data"] = [self::ENTITY => $result];
        return $this->result;
    }

}