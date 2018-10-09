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

$router->post('/login', 'AuthController@authenticate');

$router->post('/register', 'AuthController@register');

$router->post('/logout', ['middleware' => 'jwt.auth', 'uses' => 'AuthController@logout']);

$router->post('/posts', ['middleware' => 'jwt.auth', 'uses' => 'PostController@posts_create']);

$router->delete('/posts/{id}', ['middleware' => 'jwt.auth', 'uses' => 'PostController@posts_delete']);

$router->put('/posts/{id}', ['middleware' => 'jwt.auth', 'uses' => 'PostController@posts_update']);

$router->get('/posts', 'PostController@posts');

$router->get('/posts/{id}', 'PostController@one_post');



