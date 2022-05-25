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

$router->get('/status', 'StatusController@index');
$router->get('/status/{id}', 'StatusController@show');

$router->get('/inputType', 'InputTypeController@index');
$router->get('/inputType/{id}', 'InputTypeController@show');