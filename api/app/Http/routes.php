<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    $api->group(['namespace' => 'Api\Controllers'], function ($api) {
        $api->resource('users', 'UserController', ['only' => ['index', 'show', 'store', 'update', 'destroy']]);
        $api->resource('customers', 'CustomerController', ['only' => ['index', 'show', 'store', 'update', 'destroy']]);
        $api->post('customers/{id}/features', 'CustomerController@addFeatures');
        $api->resource('features', 'FeatureController', ['only' => ['index', 'show', 'store', 'update', 'destroy']]);
    });
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});
