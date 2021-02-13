<?php declare(strict_types=1);
// use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use App\Services\ScheduleService;

final class ScheduleServiceTest extends TestCase
{
    const TIME_PERIOD = 9;
    const TIME_PERIOD_IN_UNITS = "week";
    const AVAILABLE_TIME_IN_MINUTES_PER_UNIT = 240;

    //asserts that the calculation has happened
    public function assertScheduleIsCalculated() : void 
    {
        $request_data = [
            "time_period" => self::TIME_PERIOD,
            "time_period_in_units" => self::TIME_PERIOD_IN_UNITS,
            "available_time_in_minutes_per_unit" => self::AVAILABLE_TIME_IN_MINUTES_PER_UNIT, //4hrs per week
        ];
        $scheduleService = new ScheduleService();
        $scheduleService->init($request_data);
        $scheduleData = $scheduleService->calculate();
        $this->assertEquals(
            isset($scheduleData["data"]["schedule"]),
            true
        );
    }

    //asserts that the pre-conditions are met
    public function assertSchedulePreconditionsAreMet(): void
    {
        $request_data = [
            "time_period" => self::TIME_PERIOD,
            "time_period_in_units" => self::TIME_PERIOD_IN_UNITS,
            "available_time_in_minutes_per_unit" => self::AVAILABLE_TIME_IN_MINUTES_PER_UNIT, //4hrs per week
        ];
        $scheduleService = new ScheduleService();
        $scheduleService->init($request_data);
        $scheduleData = $scheduleService->calculate();
        $calculated_time_period = 0;
        if(isset($scheduleData["data"]["schedule"]) && is_array($scheduleData["data"]["schedule"])) {
            $calculated_time_period = count($scheduleData["data"]["schedule"]);
        }
        $this->assertEquals(
            $calculated_time_period,
            self::TIME_PERIOD
        );
    }

}
