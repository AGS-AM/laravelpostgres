<?php

use App\Http\Controllers\userinfoscontroller;
use Illuminate\Support\Facades\Route;

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
// routes 
Route::get('/user_infos', 'userinfoscontroller@index');
Route::post('/user_infos/add', 'userinfoscontroller@personalinput');
Route::put('user_infos/{link_id}', 'userinfoscontroller@edit');
Route::get('/user_infos/get_data', 'userinfoscontroller@get_data');
Route::delete('user_infos/{link_id}', 'userinfoscontroller@delete');