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

$router->get('/', function () {
    return view('app');
});

// API endpoint
$router->group(['prefix' => 'api'], function () use ($router) {

  $router->get('wishes',  ['uses' => 'WishController@list']);

  $router->get('wishes/{id}', ['uses' => 'WishController@get']);

  $router->post('wishes', ['uses' => 'WishController@create']);

  $router->delete('wishes/{id}', ['uses' => 'WishController@delete']);

  $router->put('wishes/{id}', ['uses' => 'WishController@update']);
});
