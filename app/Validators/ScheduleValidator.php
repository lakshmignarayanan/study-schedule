<?php

namespace App\Validators;

use App\Constants\AppConstant;
use App\Constants\HTTPConstant;
use App\Helpers\ResponseHelper;
use Validator;
use Illuminate\Validation\Rule;

class ScheduleValidator 
{

    public function validateGET($request) {
        $rules = [
            "time_period" => "required|numeric|min:1",
            "time_period_in_units" => "required",
            "time_period_in_units" => ["string", Rule::in(['minute', 'hour', 'day', 'week', 'month', 'year'])],
            "available_time_in_minutes_per_unit" => "required|numeric|min:1",
        ];

        $validator = Validator::make($request, $rules, []);
        $return = [];
        if ($validator->fails()) {
            $result['code'] = HTTPConstant::BAD_REQUEST;
            $result['message'] = __('message.'.$result['code']);
            $result['status'] =  AppConstant::VALIDATION_FAILED;
            $result['error'] = ResponseHelper::filterValidationMessage($validator->errors());
            return $result;
        }
        return true;
    }

    public function validatePOST($request)
    {

        $rules = [
            "activities" => "required|array|min:1",
            "activities.*.name" => "required",
            "activities.*.durationMinutes" => "required|numeric",
            "time_period" => "required|numeric|min:1",
            "time_period_in_units" => "required",
            "time_period_in_units" => ["string", Rule::in(['minute', 'hour', 'day', 'week', 'month', 'year'])],
            "available_time_in_minutes_per_unit" => "required|numeric|min:1",
        ];

        $validator = Validator::make($request, $rules, []);
        $return = [];
        if ($validator->fails()) {
            $result['code'] = HTTPConstant::BAD_REQUEST;
            $result['message'] = __('message.'.$result['code']);
            $result['status'] =  AppConstant::VALIDATION_FAILED;
            $result['error'] = ResponseHelper::filterValidationMessage($validator->errors());
            return $result;
        }
        return true;
    }
}
