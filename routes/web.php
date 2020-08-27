<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home/get_cuser', 'UserController@get_cuser');
Route::get('/home/get_power', 'UserController@get_power');
Route::get('/home/get_data', 'UserController@get_data');

Route::get('/user_infos', 'UserController@index');

Route::post('/user_infos/add', 'UserController@personalinput');

Route::put('user_infos/{link_id}', 'UserController@edit');
Route::get('/user_infos/get_cuser', 'UserController@get_cuser');
Route::get('/user_infos/get_power', 'UserController@get_power');
Route::get('/user_infos/get_data', 'UserController@get_data');

Route::delete('user_infos/{link_id}', 'UserController@delete');
