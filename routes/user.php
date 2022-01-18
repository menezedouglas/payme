<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Http\Controllers\UserController;

$router->group(['prefix' => 'user', 'as' => 'user.'], function () use ($router) {

    $router->post('/create', [
        'as' => 'create',
        'UserController@store'
    ]);

});
