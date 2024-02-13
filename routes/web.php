<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

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
    // redirect to login pag
    return redirect('/gate');
    // return view('welcome');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login/verify', [LoginController::class, 'verify']);
Route::post('/login/exit', [LoginController::class, 'logout']);
// Route::get('/login', "LoginController@showLoginForm")->name('login');


Route::namespace('App\Http\Controllers')->group(function () {
    Route::prefix('gate')->middleware('auth')->group(function () {
        Route::get('/', "GateController@index");
    });

    Route::prefix('rapor')->group(function () {
        Route::get('/', "RaporController@index");
    });
});
