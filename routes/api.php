<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

$router->group(['prefix' => '/v1', 'middleware' => ['validation']], function () use ($router)
{
    $router->get('/schedule', ['as' => 'schedule', 'uses' => 'Api\ScheduleController@get']);
    $router->post('/schedule', ['as' => 'schedule', 'uses' => 'Api\ScheduleController@post']); //since we need to be able to accept large request body
});