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

    $router->post('', [
        'as' => 'login',
        'uses' => 'AuthController@login'
    ]);

});

$router->group(['prefix' => 'users', 'as' => 'users.'], function () use ($router) {

    $router->get('', [
        'as' => 'all',
        'uses' => 'UserController@index',
        'middleware' => 'auth:cliente,lojista'
    ]);

    $router->post('', [
        'as' => 'create',
        'uses' => 'UserController@store'
    ]);

});

$router->group(['prefix' => 'user[/{id}]', 'as' => 'user.'], function () use ($router) {

    $router->get('', [
        'as' => 'show',
        'uses' => 'UserController@show',
        'middleware' => 'auth:cliente,lojista'
    ]);

    $router->put('', [
        'as' => 'edit',
        'uses' => 'UserController@edit',
        'middleware' => 'auth:cliente,lojista'
    ]);

    $router->delete('', [
        'as' => 'delete',
        'uses' => 'UserController@delete',
        'middleware' => 'auth:cliente,lojista'
    ]);

});

$router->group(['prefix' => 'financial', 'as' => 'financial.'], function () use ($router) {

    $router->get('', [
        'as' => 'account',
        'uses' => 'FinancialController@index',
        'middleware' => 'auth:cliente,lojista'
    ]);

    $router->post('transfer', [
        'as' => 'account',
        'uses' => 'FinancialController@newTransfer',
        'middleware' => ['auth:cliente', 'transfer']
    ]);

    $router->delete('', [
        'as' => 'account.delete',
        'uses' => 'FinancialController@deleteAccount',
        'middleware' => 'auth:cliente,lojista'
    ]);

});
