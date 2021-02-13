## Study schedule
Study schedule is a Laravel web application that calculates the schedule for a pre-defined set of activities based on the given time requirements. The service is capable of performing calculation by

- fetching data from data store
- accepting data in request payload

The application uses composer to manage dependencies. Some of the dependencies are:
1. PHPUnit
2. laravel/ui

## Application architecture
1. app\Constants\AppConstant.php
2. app\Constants\HTTPConstant.php
3. app\Helpers\ResponseHelper.php
4. app\Helpers\Util.php
5. app\Http\Controllers\Api\ScheduleController.php
6. app\Http\Controllers\Controller.php
7. app\Http\Controllers\ScheduleController.php
8. app\Http\Middleware\ValidationMiddleware.php
9. app\Models\MySQL\ActivityModel.php
10. app\Services\ScheduleService.php
11. app\Validators\Orchestrator.php
12. app\Validators\ScheduleValidator.php