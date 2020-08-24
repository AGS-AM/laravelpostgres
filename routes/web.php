<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect('/user_infos');
});
// routes 
Route::get('/user_infos', 'userinfoscontroller@index');
Route::post('/user_infos/add', 'userinfoscontroller@personalinput');
Route::put('user_infos/{link_id}', 'userinfoscontroller@edit');
Route::get('/user_infos/get_data', 'userinfoscontroller@get_data');
Route::delete('user_infos/{link_id}', 'userinfoscontroller@delete');