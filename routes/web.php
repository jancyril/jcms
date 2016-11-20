<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'as' => 'admin::', 'middleware' => 'guest'], function () {
    Route::get('login', 'LoginController@index')->name('login');
    Route::post('login', 'LoginController@login')->name('post-login');
});

Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'as' => 'admin::'], function () {
    Route::get('dashboard', function () {
        return 'dashboard';
    })->name('dashboard');
});