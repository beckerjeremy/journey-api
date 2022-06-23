<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('/status', 'StatusController@index');
    $router->get('/status/{id}', 'StatusController@show');

    $router->get('/inputType', 'InputTypeController@index');
    $router->get('/inputType/{id}', 'InputTypeController@show');

    $router->post('/login', 'AuthController@login');
    $router->post('/logout', 'AuthController@logout');
    $router->post('/refresh', 'AuthController@refresh');
    $router->post('/me', 'AuthController@me');

    $router->get('/user', 'UserController@index');
    $router->post('/user', 'UserController@store');
    $router->get('/user/{id}', 'UserController@show');
    $router->patch('/user/{id}', 'UserController@update');
    $router->delete('/user/{id}', 'UserController@destroy');

    $router->post('/token', 'TokenController@store');
    $router->get('/token/{token}', 'TokenController@show');

    $router->get('/activity', 'ActivityController@index');
    $router->post('/activity', 'ActivityController@store');
    $router->get('/activity/{id}', 'ActivityController@show');
    $router->patch('/activity/{id}', 'ActivityController@update');
    $router->delete('/activity/{id}', 'ActivityController@destroy');

    $router->get('/activity/{activity}/action', 'ActionController@index');
    $router->post('/activity/{activity}/action', 'ActionController@store');
    $router->get('/activity/{activity}/action/{id}', 'ActionController@show');
    $router->patch('/activity/{activity}/action/{id}', 'ActionController@update');
    $router->delete('/activity/{activity}/action/{id}', 'ActionController@destroy');

    $router->get('/journey', 'JourneyController@index');
    $router->post('/journey', 'JourneyController@store');
    $router->get('/journey/{id}', 'JourneyController@show');
    $router->patch('/journey/{id}', 'JourneyController@update');
    $router->delete('/journey/{id}', 'JourneyController@destroy');

    $router->get('/journey/{journey}/activity', 'JourneyActivityController@index');
    $router->post('/journey/{journey}/activity', 'JourneyActivityController@store');
    $router->get('/journey/{journey}/activity/{id}', 'JourneyActivityController@show');
    $router->patch('/journey/{journey}/activity/{id}', 'JourneyActivityController@update');
    $router->delete('/journey/{journey}/activity/{id}', 'JourneyActivityController@destroy');

    $router->get('/journey/{journey}/activity/{activity}/action', 'JourneyActionController@index');
    $router->post('/journey/{journey}/activity/{activity}/action', 'JourneyActionController@store');
    $router->get('/journey/{journey}/activity/{activity}/action/{id}', 'JourneyActionController@show');
    $router->patch('/journey/{journey}/activity/{activity}/action/{id}', 'JourneyActionController@update');
    $router->delete('/journey/{journey}/activity/{activity}/action/{id}', 'JourneyActionController@destroy');

    $router->get('/input', 'InputController@index');
    $router->post('/input', 'InputController@store');
    $router->get('/input/{id}', 'InputController@show');
    $router->patch('/input/{id}', 'InputController@update');
    $router->delete('/input/{id}', 'InputController@destroy');

    $router->get('/text', 'TextInputController@index');
    $router->post('/text', 'TextInputController@store');
    $router->get('/text/{id}', 'TextInputController@show');
    $router->patch('/text/{id}', 'TextInputController@update');
    $router->delete('/text/{id}', 'TextInputController@destroy');

    $router->get('/image', 'ImageInputController@index');
    $router->post('/image', 'ImageInputController@store');
    $router->get('/image/{id}', 'ImageInputController@show');
    $router->patch('/image/{id}', 'ImageInputController@update');
    $router->delete('/image/{id}', 'ImageInputController@destroy');

    $router->get('/video', 'VideoInputController@index');
    $router->post('/video', 'VideoInputController@store');
    $router->get('/video/{id}', 'VideoInputController@show');
    $router->patch('/video/{id}', 'VideoInputController@update');
    $router->delete('/video/{id}', 'VideoInputController@destroy');
    $router->get('/video/{id}/download', 'VideoInputController@download');
});