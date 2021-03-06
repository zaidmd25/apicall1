<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/signup','ApiController@signup');
Route::post('/signin','ApiController@signin');
Route::post('/sendtoken{token}','ForgotpassController@sendpasswordtoken');
// Route::post('/resetpass/{token}',['uses'=>'ForgotpassController@resetpassword']);
Route::post('/resetpassword',['uses'=>'ForgotpassController@resetpassword']);
// Route::post('/sendemail',function () {
// 	Mail::send('email.reminder',[], function ($m) {
// 		$m->to('mdzaiduv@gmail.com')->subject('Your Reminder!');
// 	});
// });
Route::post('/sendreset','ForgotpassController@SentResetLink');
Route::get('/reset/form/{token}','ApiForgotController@ResetForm');