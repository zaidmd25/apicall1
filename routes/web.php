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
Route::get('/reset/form/{token}','Api\ForgotpassController@ResetForm');
Route::get('/multiuploads', 'FileController@uploadform');
Route::post('/multiuploads', 'FileController@uploadfile');
