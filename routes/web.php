<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use FontLib\Table\Type\name;

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


Route::namespace('App\Http\Controllers')->middleware('auth')->group(function () {
    Route::prefix('gate')->group(function () {
        Route::get('/', "GateController@index");
    });

    Route::prefix('rapor')->group(function () {
        // Route::get('/', "RaporController@index");
        Route::get('/', "RaporController@dashboard")->name('rapor');
        Route::get('/dashboard', "RaporController@dashboard");
        Route::get('/pengaturan', "RaporController@dashboard");
        Route::post('/generateDataRapor', "RaporController@generateDataRapor");

        // komponen indikator kinerja
        Route::get('/indikator-kinerja', "KomponenIndikatorKinerjaController@index")->name('indikator-kinerja');
        Route::get('/indikator-kinerja/create', "KomponenIndikatorKinerjaController@create")->name('indikator-kinerja.create');
        Route::post('/indikator-kinerja/store', "KomponenIndikatorKinerjaController@store");
        Route::put('/indikator-kinerja/{id}', "KomponenIndikatorKinerjaController@update");
        Route::delete('/indikator-kinerja/{id}', "KomponenIndikatorKinerjaController@destroy");

        // sub komponen indikator kinerja
        Route::get('/subindikator-kinerja', "SubkomponenIndikatorKinerjaController@index")->name('subindikator-kinerja');

        // laporan
        Route::get('/laporan', "LaporanController@index")->name('laporan');
        Route::get('/generate-laporan-kinerja', "LaporanController@generateLaporanKinerja");

        // export excel
        Route::get('/download-template-rapor-kinerja', "ExcelController@RaporTemplate");

        // import excel
        Route::post('/import-rapor-kinerja', "ImportController@importRaporKinerja")->named('rapor.import-rapor-kinerja');
    });

    Route::prefix('dosen')->group(function () {
        Route::get('/get-nama-dosen', "DosenController@getNamaDosen")->name('getNamaDosen');
    });
});
