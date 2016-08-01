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

$app->get('/', function () use ($app) {
    return $app->version();
});

$app->group(['prefix' => 'v1','namespace' => 'App\Http\Controllers\v1'], function () use ($app) {
    /**
     * WORKLOGS
     */
    $app->get('worklogs', ['uses' => 'WorklogsController@index']);
    $app->get('worklogs/{id}', ['uses' => 'WorklogsController@show']);
    $app->delete('worklogs/{id}', ['uses' => 'WorklogsController@destroy']);
    $app->put('worklogs/{id}', ['uses' => 'WorklogsController@update']);
    $app->post('worklogs', ['uses' => 'WorklogsController@create']);
    /**
     * TAGS
     */
    $app->get('tags', ['uses' => 'TagsController@index']);
    $app->get('tags/{id}', ['uses' => 'TagsController@show']);
    $app->delete('tags/{id}', ['uses' => 'TagsController@destroy']);
    $app->put('tags/{id}', ['uses' => 'TagsController@update']);
    $app->post('tags', ['uses' => 'TagsController@create']);
    /**
     * USERS
     */
    $app->get('me', ['uses' => 'UsersController@show']);
    $app->put('me', ['uses' => 'UsersController@update']);
    $app->delete('me', ['uses' => 'UsersController@destroy']);
    $app->post('register', ['uses' => 'UsersController@create']);
    /**
     * AUTH
     */
    $app->get('session', ['uses' => 'SessionController@show']);
    $app->post('session', ['uses' => 'SessionController@create']);
    /**
     * PASSWORD
     */
    $app->post('password/request', ['uses' => 'PasswordController@create']);
    $app->put('password/reset', ['uses' => 'PasswordController@update']);
});