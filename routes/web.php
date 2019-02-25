<?php

use Symfony\Component\HttpKernel\Tests\Fragment\RoutableFragmentRendererTest;

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
Route::resource('users', 'UserController');
Route::resource('taskStatus', 'TaskStatusController');
Route::resource('task', 'TaskController');

Route::get('user/change-password', 'UserController@changePasswordShow')->name('user.changePassword');
Route::patch('user/change-password', 'UserController@changePasswordStore')->name('user.storePassword');
