<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::namespace('App\Http\Controllers')->group(function () {
    Route::prefix('login')->group(function () {
        Route::get('/', "LoginController@showLoginForm");
        Route::get('/getToken', "SinkronasiController@getToken");
        Route::get('/getDataDosen', "SinkronasiController@getDataDosen");
    });

    Route::prefix('gate')->group(function () {
        Route::get('/', "GateController@index");
    });

    Route::prefix('rapor')->group(function () {
        Route::get('/', "RaporController@index");
    });
});
