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
/**
 * Auth Routes
 */
$router->group(['prefix' => 'api/v1'], function () use ($router){

    $router->group(['prefix' => 'auth'], function () use ($router){
        $router->post('/login', 'Api\AuthController@login');
    });

    $router->group(['prefix' => 'auth'], function () use ($router){
        $router->post('/logout', ['middleware' => ['auth'], 'uses' => 'Api\AuthController@logout']);
    });

});

/**
 * Company Admin Routes
 */
$router->group(['prefix' => 'api/v1'], function () use ($router){

    $router->group(['prefix' => 'admin/company'], function () use ($router){
        $router->get('/list', 'Api\CompanyController@index');
        $router->post('/register', 'Api\CompanyController@store');
    });

});
