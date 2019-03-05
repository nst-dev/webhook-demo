<?php

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

/**
 * @var Laravel\Lumen\Routing\Router $router
 */

$router->group([
    'middleware' => ['auth:app'],
], function () use ($router) {
    $router->group([
        'prefix' => 'events',
        'namespace' => 'Event\Controllers',
    ], function () use ($router) {
        $router->post('/', 'EventController@publish');
    });
});
