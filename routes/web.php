<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/edit_profile', 'UsersController@edit_profile')->name('edit_profile');
Route::post('/update_profile', 'UsersController@update_profile')->name('update_profile');

Route::resource('posts', 'PostsController');

Route::resource('comments', 'CommentsController');

