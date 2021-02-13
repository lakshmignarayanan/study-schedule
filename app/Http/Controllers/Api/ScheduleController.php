<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\ScheduleService;
use App\Constants\HTTPConstant;
use App\Helpers\ResponseHelper;
use Theme;
use App\Http\Controllers\Controller;

class ScheduleController extends Controller {

    private $request, $scheduleService;

    public function __construct(Request $request, ScheduleService $scheduleService)
    {
        $this->request = $request;
        $this->scheduleService = $scheduleService;
    }

    public function get()
    {
        $requestData = $this->request->all();
        $limit = $requestData['limit']??Config('schedule.limit');
        $offset = $requestData['offset']??0;

        $this->scheduleService->init($requestData);
        $scheduleData = $this->scheduleService->calculate();
        // return Theme::view('schedule', $scheduleData);
        return ResponseHelper::format($scheduleData);
    }

    public function post() {
        $requestData = $this->request->all();
        $limit = $requestData['limit']??Config('schedule.limit');
        $offset = $requestData['offset']??0;

        $this->scheduleService->init($requestData);
        $scheduleData = $this->scheduleService->calculate();
        return ResponseHelper::format($scheduleData);
    }

}