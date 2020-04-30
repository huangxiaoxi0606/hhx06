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
Route::post('/uploadFiles', 'UploadsController@uploadImg');
Route::get('/direction', 'Hhx\DirectionController@getDirection');
Route::get('/travel_list', 'Hhx\TravelController@getList');
Route::get('/travel_intro/{id}', 'Hhx\TravelController@getIntro');
Route::any('/index', 'HhxController@indexs');
