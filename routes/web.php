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

// app index
$router->get('/', function () {
    return view('app');
});


// API endpoint
$router->group(['prefix' => 'api'], function () use ($router) {

  // auth
  $router->post('auth', ['uses' => 'AuthController@authenticate']);

  // wishes read access: everybody
  $router->group(['prefix' => 'wishes'], function () use ($router) {

    $router->get('/',  ['uses' => 'WishController@list']);
    $router->get('/{id}', ['uses' => 'WishController@get']);
  });

  // auth check middleware
  $router->group(['middleware' => 'jwt.auth'], function() use ($router) {

    // wishes write access: logged in users only
    $router->group(['prefix' => 'wishes'], function () use ($router) {
      $router->post('/', ['uses' => 'WishController@create']);
      $router->delete('/{id}', ['uses' => 'WishController@delete']);
      $router->put('/{id}', ['uses' => 'WishController@update']);
    });

    // users : logged in users only
    $router->group(['prefix' => 'users'], function () use ($router) {
      $router->get('/',  ['uses' => 'UserController@list']);
      $router->get('/{id}', ['uses' => 'UserController@get']);
      $router->post('/{id}', ['uses' => 'UserController@update']);
    });
  });

});
