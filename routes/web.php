<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use FontLib\Table\Type\name;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RaporController;
use App\Http\Controllers\KuisionerController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use App\Http\Controllers\KuesionerController;
use App\Http\Controllers\BankSoalController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\PertanyaanController;
use App\Http\Controllers\KuesionerSDMController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\PegawaiController;


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
    Route::get('/auth/change-password', "LoginController@changePassword")->name('changePassword');
    Route::post('/auth/update-password', "LoginController@updatePassword")->name('updatePassword');

    Route::prefix('gate')->group(function () {
        Route::get('/', "GateController@index");
        Route::post('/set-role', "GateController@setRole")->name('gate.setRole');
    });

    Route::prefix('master')->group(function () {
        // Dashboard
        Route::get('/', "MasterController@index")->name('master');

        // modul
        Route::get('/modul', "MasterController@modul")->name('master.modul');
        Route::get('/modul/create', "MasterController@createModul")->name('master.modul.create');
        Route::post('/modul/store', "MasterController@storeModul")->name('master.modul.store');
        Route::get('/modul/edit/{id}', "MasterController@editModul")->name('master.modul.edit');
        Route::put('/modul/{id}', "MasterController@updateModul")->name('master.modul.update');


        // Route::delete('/modul/destroy-role-modul/{id}', "MasterController@destroyRoleModul")->name('deleteRoleModul');

        // menu

        // role
        Route::get('/role', "MasterController@role")->name('master.role');
        Route::get('/role/create', "MasterController@createRole")->name('master.role.create');
        Route::post('/role/store', "MasterController@storeRole")->name('master.role.store');
        // detail
        Route::get('/role/detail/{id}', "MasterController@showRole")->name('master.role.detail');
        Route::get('/role/edit/{id}', "MasterController@editRole")->name('master.role.edit');
        Route::put('/role/{id}', "MasterController@updateRole")->name('master.role.update');
        Route::delete('/role/{id}', "MasterController@destroyRole")->name('master.role.delete');

        // user
        Route::get('/user', "MasterController@user")->name('master.user');
        Route::get('/user/create', "MasterController@createUser")->name('master.user.create');
        Route::post('/user/store', "MasterController@storeUser")->name('master.user.store');
        Route::get('/user/detail/{id}', "MasterController@showUser")->name('master.user.detail');
        Route::get('/user/edit/{id}', "MasterController@editUser")->name('master.user.edit');
        Route::put('/user/{id}', "MasterController@updateUser")->name('master.user.update');
        Route::delete('/user/{id}', "MasterController@destroyUser")->name('master.user.delete');

        // pegawai
        Route::get('/pegawai', "MasterController@pegawai")->name('master.pegawai');

        // unitkerja
        Route::get('/unit-kerja', "MasterController@unitkerja")->name('master.unit-kerja');

        // sinkronasi
        Route::get('/sinkronasi', "MasterController@sinkronasi")->name('master.sinkronasi');
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

    Route::prefix('kuesioner')->group(function () {
        Route::get('/', "KuesionerController@dashboard")->name('kuesioner');

        Route::get('/banksoal', "BankSoalController@index")->name('kuesioner.banksoal');
        Route::get('/banksoal/create', "BankSoalController@create")->name('kuesioner.banksoal.create');

        //import data banksoal excel
        // Route::post('/banksoal/import-soal', "ImportController@importSoal")->name('kuesioner.banksoal.import-soal');

        Route::post('/banksoal/store', "BankSoalController@store");
        Route::delete('/banksoal/{id}', "BankSoalController@destroy");

        Route::get('/banksoal/data', "BankSoalController@getAllDataSoal")->name('kuesioner.banksoal.data');

        // detail
        Route::get('/banksoal/data-soal/{id}', "BankSoalController@show")->name('kuesioner.banksoal.show');
        Route::get('/banksoal/data-soal/{id}/edit', "BankSoalController@edit");
        Route::put('/banksoal/{id}', "BankSoalController@update");

        Route::get('/banksoal/pertanyaan/create/{id}', "pertanyaanController@create")->name('kuesioner.banksoal.create-pertanyaan');
        Route::post('/banksoal/pertanyaan/store', "pertanyaanController@store");
        Route::get('/banksoal/pertanyaan/{id}', "pertanyaanController@show")->name('kuesioner.banksoal.list-pertanyaan');
        Route::post('/banksoal/pertanyaan/upload', "ImportController@importPertanyaan")->name('kuesioner.banksoal.pertanyaan.upload');

        //kuesioner-sdm
        Route::get('/kuesioner-sdm', "KuesionerSDMController@index")->name('kuesioner.kuesioner-sdm');
        Route::get('/kuesioner-sdm/create', "KuesionerSDMController@create")->name('kuesioner.sdm.create');
        Route::post('/kuesioner-sdm/store', "KuesionerSDMController@store")->name('kuesioner.kuesioner-sdm.store');

        // json
        Route::get('/kuesioner-sdm/data', "KuesionerSDMController@getAllDataKuesionerSDM")->name('kuesioner.kuesioner-sdm.data');

        //edit
        Route::get('/kuesioner-sdm/{id}', "KuesionerSDMController@edit")->name('kuesioner.kuesioner-sdm.edit');
        Route::post('/kuesioner-sdm/update', "KuesionerSDMController@update")->name('kuesioner.kuesioner-sdm.update');

        //delete
        Route::delete('/kuesioner-sdm/{id}', "KuesionerSDMController@destroy")->name('kuesioner.kuesioner-sdm.delete');

        Route::get('/kuesioner-sdm/detail/{id}', "KuesionerSDMController@show")->name('kuesioner.kuesioner-sdm.detail');
        Route::get('/kuesioner-sdm/responden/{id}', "KuesionerSDMController@responden")->name('kuesioner.kuesioner-sdm.responden');
        Route::post('/kuesioner-sdm/responden/tambah-responden', "KuesionerSDMController@tambahResponden")->name('tambahResponden');
        Route::delete('/kuesioner-sdm/responden/{id}', "KuesionerSDMController@deleteResponden")->name('kuesioner.kuesioner-sdm.responden.delete');

        //SoalKuesionerSDM
        Route::post('/soalkuesionersdm/store', "KuesionerSDMController@createSoalKuesionerSDM")->name('kuesioner.soalkuesionersdm.store');
        Route::delete('/soalkuesionersdm/{id}', "KuesionerSDMController@deleteSoalKuesionerSDM")->name('kuesioner.soalkuesionersdm.delete');

        //penilaian
        Route::get('/penilaian', "PenilaianController@index")->name('kuesioner.penilaian');
        Route::get('/penilaian/mulai/{id}', "PenilaianController@mulaiPenilaian")->name('kuesioner.penilaian.mulai');
        Route::post('/penilaian/store', "PenilaianController@store")->name('kuesioner.penilaian.store');
    });

    Route::prefix('dosen')->group(function () {
        Route::get('/get-nama-dosen', "DosenController@getNamaDosen")->name('getNamaDosen');
    });

    Route::prefix('pegawai')->group(function () {
        Route::get('/get-nama-pegawai', "PegawaiController@getNamaPegawai")->name('getNamaPegawai');
        Route::get('/get-data-pegawai', "PegawaiController@getDataPegawai")->name('getDataPegawai');
    });

    Route::prefix('data')->group(function () {
        Route::get('/get-nama-pegawai', "PegawaiController@getNamaPegawai")->name('getNamaPegawai');
        Route::get('/get-data-pegawai', "PegawaiController@getDataPegawai")->name('getDataPegawai');

        // getdatamodul
        Route::get('/get-data-modul', "MasterController@getModulData")->name('getModulData');
        Route::delete('/destroy-role-modul/{id}', "MasterController@destroyRoleModul")->name('deleteRoleModul');
        Route::post('/add-role-modul', "MasterController@tambahRoleModul")->name('addRoleModul');

        Route::get('/get-roles/{modul_id}', 'GateController@showRole')->name('getRoles');

        // getdatasoal
        Route::get('/get-data-soal', "BankSoalController@getDataSoal")->name('getDataSoal');
    });

    Route::prefix('export')->group(function () {
        Route::get('/download-template-upload-pertanyaan', "ExcelController@uploadTemplatePertanyaan")->name('export.uploadTemplatePertanyaan');
        Route::get('/download-template-kuesioner-sdm', "ExcelController@downloadTemplateKuesionerSDM")->name('export.downloadTemplateKuesionerSDM');
    });

    Route::prefix('import')->group(function () {
        Route::post('/import-kuesioner-sdm', "ImportController@importKuesionerSDM")->name('importKuesionerSDM');
    });

    //test
    Route::get('/test', "TestController@index");
});
