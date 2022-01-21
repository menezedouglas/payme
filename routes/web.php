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

$router->group(['prefix' => 'auth', 'as' => 'auth.'], function () use ($router) {

    $router->post('/login', [
        'as' => 'login',
        'uses' => 'AuthController@login'
    ]);

});

$router->group(['prefix' => 'user', 'as' => 'user.'], function () use ($router) {

    $router->get('', [
        'as' => 'all',
        'uses' => 'UserController@index'
    ]);

    $router->get('/{id}', [
        'as' => 'show',
        'uses' => 'UserController@show'
    ]);

    $router->post('', [
        'as' => 'create',
        'uses' => 'UserController@store'
    ]);

    $router->put('', [
        'as' => 'edit',
        'uses' => 'UserController@edit'
    ]);

    $router->delete('/{id}', [
        'as' => 'delete',
        'uses' => 'UserController@delete'
    ]);

});
