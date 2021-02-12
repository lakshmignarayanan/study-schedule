<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

$router->group(['middleware' => ['validation']], function () use ($router)
{
    $router->get('/schedule', ['as' => 'schedule', 'uses' => 'ScheduleController@get']);
    $router->post('/schedule', ['as' => 'schedule', 'uses' => 'ScheduleController@post']); //since we need to be able to accept large request body
});