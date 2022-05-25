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

    $router->get('/activity', 'ActivityController@index');
    $router->post('/activity', 'ActivityController@store');
    $router->get('/activity/{id}', 'ActivityController@show');
    $router->patch('/activity/{id}', 'ActivityController@update');
    $router->delete('/activity/{id}', 'ActivityController@destroy');
});