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
Route::get('/users', 'UserController@index')->name('users.index');
Route::get('/user/show', 'UserController@show')->name('user.show');
Route::patch('/user/show', 'UserController@update')->name('user.save');
Route::delete('user/show', 'UserController@destroy')->name('user.delete');

