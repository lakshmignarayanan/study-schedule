<?php

namespace App\Validators;

use App\Constants\AppConstant;
use App\Constants\HTTPConstant;
use App\Helpers\ResponseHelper;
use Validator;
use Illuminate\Validation\Rule;

class ScheduleValidator 
{
    public function validatePOST($request)
    {

        $rules = [
            "activities" => "required|array|min:1",
            "activities.*.name" => "required",
            "activities.*.durationMinutes" => "required|numeric",
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
