<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['namespace' => 'Api'], function() {

    Route::resource('users', 'UsersController', ['only' => [
        'index', 'store', 'show', 'update', 'destroy'
    ]]);

    Route::resource('books', 'BooksController');

    Route::group(['prefix' => 'auth', 'namespace' => 'Auth', 'as' => 'api.auth'], function() {
       Route::post('login', 'AuthController@login')->name('.login');
       Route::post('register', 'AuthController@register')->name('.register');
    });
});

