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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/login', 'LoginController@login')->name('login');
Route::middleware('auth:api')->get('/user', 'UserController@index')->name('index');
Route::post('/user', 'UserController@store')->name('store');
Route::middleware('auth:api')->post('/user/update/{id}', 'UserController@update')->name('update');
Route::middleware('auth:api')->get('/user/delete/{id}', 'UserController@destroy')->name('destroy');
