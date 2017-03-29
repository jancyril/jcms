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

Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'as' => 'admin::', 'middleware' => 'auth'], function () {
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');

    // Routes for posts
    Route::get('posts', 'PostsController@index')->name('posts');
    Route::get('posts/get', 'PostsController@get')->name('get-posts');
    Route::get('posts/new', 'PostsController@create')->name('new-post');
    Route::post('posts/new', 'PostsController@store')->name('post-post');

    // Routes for post categories
    Route::get('post-categories', 'PostCategoriesController@index')->name('post-categories');
    Route::get('post-categories/get', 'PostCategoriesController@get')->name('get-post-categories');
    Route::post('post-categories/new', 'PostCategoriesController@store')->name('post-post-category');
    Route::put('post-categories/{id}/edit', 'PostCategoriesController@update')->name('put-post-category');
    Route::delete('post-categories/delete/{id}', 'PostCategoriesController@destroy')->name('delete-post-category');

    // Routes for files
    Route::post('files/new', 'FilesController@store')->name('post-file');
    Route::delete('files/delete/{file}', 'FilesController@delete')->name('delete-file');
});
