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

//Api v1 routes
Route::group(['prefix' => 'v1', 'middleware' => []], function () {    
    
    //unprotected routes
    Route::post('/auth/login','App\Http\Controllers\Auth\AuthController@login');   

    //protected routes
    Route::group(['middleware' => ['jwt.verify']], function () {
        
        Route::post('/auth/refresh','App\Http\Controllers\Auth\AuthController@refresh');
        Route::post('/auth/logout','App\Http\Controllers\Auth\AuthController@logout');
        Route::get('me', 'App\Http\Controllers\Auth\AuthController@me');


        Route::resource('company','App\Http\Controllers\CompanyController');
        Route::resource('employee','App\Http\Controllers\EmployeeController');

    });

});


