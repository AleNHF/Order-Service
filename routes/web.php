<?php

/** @var \Laravel\Lumen\Routing\Router $router */
use App\Http\Controllers\SupplierController;

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
    $router->get('/suppliers', 'SupplierController@index');
    $router->get('/suppliers/{id}', 'SupplierController@show');
    $router->post('/suppliers', 'SupplierController@store');
    $router->put('/suppliers/{id}', 'SupplierController@update');
    $router->delete('/suppliers/{id}', 'SupplierController@destroy');

    $router->get('/orders', 'OrderController@index');
    $router->get('/orders/{id}', 'OrderController@show');
    $router->post('/orders', 'OrderController@store');
    $router->put('/orders/{id}', 'OrderController@update');
    $router->delete('/orders/{id}', 'OrderController@destroy');
});
