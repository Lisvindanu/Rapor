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
    Route::get('/auth/change-password-after', "LoginController@changePasswordSecond")->name('changePasswordSecond');
    Route::post('/auth/update-password', "LoginController@updatePassword")->name('updatePassword');

    Route::prefix('gate')->group(function () {
        Route::get('/', "GateController@index")->name('gate');
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
        Route::get('/user/detail/{id}', "MasterController@showUser")->name('master.user.detail');
        Route::get('/user/edit/{id}', "MasterController@editUser")->name('master.user.edit');

        // master.user.reset-password
        Route::post('/user/reset-password', "MasterController@resetPassword")->name('master.user.reset-password');
        Route::post('/user/store', "MasterController@storeUser")->name('master.user.store');
        Route::put('/user/{id}', "MasterController@updateUser")->name('master.user.update');
        Route::delete('/user/{id}', "MasterController@destroyUser")->name('master.user.delete');

        // pegawai
        Route::get('/pegawai', "MasterController@pegawai")->name('master.pegawai');

        // unitkerja
        Route::get('/unit-kerja', "MasterController@unitkerja")->name('master.unit-kerja');

        // sinkronasi
        Route::get('/sinkronasi', "SinkronasiController@index")->name('master.sinkronasi');
        Route::post('/sinkronasi/get-token', "SinkronasiController@getToken")->name('master.sinkronasi.getToken');
        Route::get('/sinkronasi/mahasiswa', "SinkronasiController@mahasiswa")->name('master.sinkronasi.mahasiswa');
        Route::post('/sinkronasi/get-mahasiswa', "SinkronasiController@getDataMahasiswa")->name('master.sinkronasi.getMahasiswa');
        Route::get('/sinkronasi/kelas-kuliah', "SinkronasiController@kelasKuliah")->name('master.sinkronasi.kelasKuliah');
        Route::get('/sinkronasi/jadwal-kuliah', "SinkronasiController@jadwalKuliah")->name('master.sinkronasi.jadwalKuliah');
        Route::get('/sinkronasi/presensi-kuliah', "SinkronasiController@presensiKuliah")->name('master.sinkronasi.presensiKuliah');


        Route::post('/sinkronasi/get-kelas-kuliah', "SinkronasiController@getDataKelasKuliah")->name('master.sinkronasi.getDataKelasKuliah');
        Route::post('/sinkronasi/get-jadwal-kuliah', "SinkronasiController@getDataJadwalKuliah")->name('master.sinkronasi.getDataJadwalKuliah');
        Route::post('/sinkronasi/get-presensi-kuliah', "SinkronasiController@getDataPresensiKuliah")->name('master.sinkronasi.getDataPresensiKuliah');

        // sinkronasi remedial
        Route::get('/sinkronasi/remedial', "SinkronasiController@remedial")->name('master.sinkronasi.remedial');
        Route::post('/sinkronasi/get-krs', "SinkronasiController@getDataKrs")->name('master.sinkronasi.getDataKrs');

        // AKM
        Route::get('/sinkronasi/akm', "SinkronasiController@akm")->name('master.sinkronasi.akm');
        Route::post('/sinkronasi/get-akm', "SinkronasiController@getDataAkm")->name('master.sinkronasi.getDataAkm');

        // roleuser
        Route::post('/roleuser', "RoleUserController@create")->name('master.roleuser.create');
        Route::delete('/roleuser/{id}', "RoleUserController@delete")->name('master.roleuser.delete');

        //hitung presensi krs mahasiswa
        Route::post('/sinkronasi/hitung-presensi', "SinkronasiController@hitungPresensi")->name('master.sinkronasi.hitungPresensi');
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

        Route::get('/banksoal/pertanyaan/create/{id}', "PertanyaanController@create")->name('kuesioner.banksoal.create-pertanyaan');
        Route::post('/banksoal/pertanyaan/store', "PertanyaanController@store");
        Route::get('/banksoal/pertanyaan/{id}', "PertanyaanController@show")->name('kuesioner.banksoal.list-pertanyaan');
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

        //hasil kuesioner 
        Route::get('/kuesioner-sdm/hasil/{id}', "KuesionerSDMController@hasilKuesionerSDM")->name('kuesioner.kuesioner-sdm.hasil');

        //SoalKuesionerSDM
        Route::post('/soalkuesionersdm/store', "KuesionerSDMController@createSoalKuesionerSDM")->name('kuesioner.soalkuesionersdm.store');
        Route::post('/soalkuesionersdm/copy', "KuesionerSDMController@copySoalKuesionerSDM")->name('kuesioner.soalkuesionersdm.copy');
        Route::delete('/soalkuesionersdm/{id}', "KuesionerSDMController@deleteSoalKuesionerSDM")->name('kuesioner.soalkuesionersdm.delete');

        //penilaian
        Route::get('/penilaian', "PenilaianController@index")->name('kuesioner.penilaian');
        Route::get('/penilaian/riwayat', "PenilaianController@riwayat")->name('kuesioner.penilaian.riwayat');
        Route::get('/penilaian/mulai/{id}', "PenilaianController@mulaiPenilaian")->name('kuesioner.penilaian.mulai');
        Route::post('/penilaian/store', "PenilaianController@store")->name('kuesioner.penilaian.store');

        //referensi
        Route::get('/referensi', "KuesionerController@referensi")->name('kuesioner.referensi');

        //responden
        Route::delete('/hapus-semua-responden', "RespondenController@deleteAllResponden")->name('deleteAllResponden');
    });

    Route::prefix('dosen')->group(function () {
        Route::get('/get-nama-dosen', "DosenController@getNamaDosen")->name('getNamaDosen');
    });

    Route::prefix('pegawai')->group(function () {
        Route::get('/get-nama-pegawai', "PegawaiController@getNamaPegawai");
        // Route::get('/get-data-pegawai', "PegawaiController@getDataPegawai")->name('getDataPegawai');
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

        // getdatakuesionersdm
        Route::get('/get-data-kuesioner-sdm', "KuesionerSDMController@getDataKuesionerSDM")->name('getDataKuesionerSDM');
        Route::get('/get-data-kuesioner-sdm-for-copy', "KuesionerSDMController@getKuesionerSDMforCopy")->name('getKuesionerSDMforCopy');

        // getdataresponden
        Route::get('/get-data-responden', "PegawaiController@getDataResponden")->name('getDataResponden');

        // getdatauser
        Route::get('/get-data-user', "UserController@getAllDataUser")->name('getDataUser');

        // getdatamahasiswa
        Route::get('/get-nama-mahasiswa', "MahasiswaController@getNamaSiswa")->name('getNamaMahasiswa');
    });

    Route::prefix('export')->group(function () {
        Route::get('/download-template-upload-pertanyaan', "ExcelController@uploadTemplatePertanyaan")->name('export.uploadTemplatePertanyaan');
        Route::get('/download-template-kuesioner-sdm', "ExcelController@downloadTemplateKuesionerSDM")->name('export.downloadTemplateKuesionerSDM');
        Route::get('/download-daftar-mahasiswa-non-aktif', "ExcelController@downloadMhsNonAktif")->name('export.downloadMhsNonAktif');
        Route::get('/download-rekomendasi-kelas-perkuliahan', "ExcelController@downloadRekomendasiKelas")->name('export.downloadRekomendasiKelas');
        Route::get('/download-template-rekening-koran', "ExcelController@downloadTemplateRekor")->name('export.downloadTemplateRekor');
    });

    Route::prefix('import')->group(function () {
        Route::post('/import-kuesioner-sdm', "ImportController@importKuesionerSDM")->name('importKuesionerSDM');
    });

    Route::prefix('vakasi')->group(function () {
        Route::get('/', "TestController@index")->name('vakasi');
    });

    Route::prefix('remedial')->group(function () {
        Route::get('/', "RemedialController@index")->name('remedial');
        Route::prefix('periode')->group(function () {
            Route::prefix('prodi')->group(function () {
                Route::get('/', "RemedialPeriodeProdiController@index")->name('remedial.periode.prodi');
                Route::post('/', "RemedialPeriodeProdiController@store")->name('remedial.periode.prodi.store');
                Route::delete('/{id}', "RemedialPeriodeProdiController@destroy")->name('remedial.periode.prodi.delete');
            });

            Route::prefix('tarif')->group(function () {
                Route::get('/', "RemedialPeriodeTarifController@index")->name('remedial.periode.tarif');
                Route::post('/', "RemedialPeriodeTarifController@store")->name('remedial.periode.tarif.store');
                Route::delete('/{id}', "RemedialPeriodeTarifController@destroy")->name('remedial.periode.tarif.delete');
            });

            Route::get('/', "RemedialPeriodeController@index")->name('remedial.periode');
            Route::get('/create', "RemedialPeriodeController@create")->name('remedial.periode.create');
            Route::get('/{id}', "RemedialPeriodeController@edit")->name('remedial.periode.edit');
            Route::post('/', "RemedialPeriodeController@store")->name('remedial.periode.store');
            Route::post('/salin', "RemedialPeriodeController@salinPeriode")->name('remedial.periode.salin');
            Route::put('/{id}', "RemedialPeriodeController@update")->name('remedial.periode.update');
            Route::delete('/{id}', "RemedialPeriodeController@destroy")->name('remedial.periode.delete');
        });

        Route::prefix('mahasiswa')->group(function () {
            Route::get('/', "RemedialMahasiswaController@index")->name('remedial.mahasiswa');
            Route::get('/create', "RemedialMahasiswaController@create")->name('remedial.mahasiswa.create');
            Route::get('/{id}', "RemedialMahasiswaController@edit")->name('remedial.mahasiswa.edit');
            Route::post('/periode', "RemedialMahasiswaController@index")->name('remedial.mahasiswa.periode');
            Route::post('/', "RemedialMahasiswaController@store")->name('remedial.mahasiswa.store');
            Route::put('/{id}', "RemedialMahasiswaController@update")->name('remedial.mahasiswa.update');
            Route::delete('/{id}', "RemedialMahasiswaController@destroy")->name('remedial.mahasiswa.delete');
        });

        Route::prefix('ajuan')->group(function () {
            Route::prefix('detail')->group(function () {
                Route::get('/{id}', "RemedialAjuanController@ajuandetail")->name('remedial.ajuan.detail');
                Route::post('/{id}', "RemedialAjuanController@detailStore")->name('remedial.ajuan.detail.store');
                Route::delete('/{id}', "RemedialAjuanController@detailDelete")->name('remedial.ajuan.detail.delete');
            });
            Route::get('/', "RemedialAjuanController@index")->name('remedial.ajuan');
            Route::get('/daftar-ajuan', "RemedialAjuanController@daftarAjuan")->name('remedial.ajuan.daftarAjuan');
            Route::post('/', "RemedialAjuanController@storeAjax")->name('remedial.ajuan.storeAjax');
            Route::post('/upload-bukti-pembayaran', "RemedialAjuanController@uploadBukti")->name('remedial.ajuan.uploadBukti');
            Route::post('/upload-rekening-koran', "RemedialAjuanController@uploadRekeningKoran")->name('remedial.ajuan.uploadRekeningKoran');

            Route::post('/verifikasi-ajuan', "RemedialAjuanController@verifikasiAjuan")->name('remedial.ajuan.verifikasiAjuan');
            Route::delete('/{id}', "RemedialAjuanController@deleteAjax")->name('remedial.ajuan.deleteAjax');
        });

        Route::prefix('pelaksanaan')->group(function () {
            // Route::get('/', "RemedialPelaksanaanController@daftarMatakuliah")->name('remedial.pelaksanaan');
            Route::get('/', "RemedialPelaksanaanDaftarMKController@daftarMatakuliah")->name('remedial.pelaksanaan');

            Route::prefix('daftar-mk')->group(function () {
                Route::get('/', "RemedialPelaksanaanDaftarMKController@daftarMatakuliah")->name('remedial.pelaksanaan.daftar-mk');
                Route::get('/peserta', "RemedialPelaksanaanDaftarMKController@pesertaMatakuliah")->name('remedial.pelaksanaan.daftar-mk.peserta');
                Route::get('/kelas', "RemedialPelaksanaanDaftarMKController@kelasMatakuliah")->name('remedial.pelaksanaan.daftar-mk.kelas');
                Route::post('/batal-kelas', "RemedialPelaksanaanDaftarMKController@batalkanKelasAjuan")->name('remedial.pelaksanaan.daftar-mk.batalkanKelasAjuan');
                Route::put('/edit-ajuan', "RemedialPelaksanaanDaftarMKController@editKelasAjuan")->name('remedial.pelaksanaan.daftar-mk.editKelasAjuan');
            });

            Route::prefix('daftar-kelas')->group(function () {
                Route::post('/tambahPerMK', "RemedialPelaksanaanKelasController@tambahPerMKAjax")->name('remedial.pelaksanaan.daftar-kelas.tambahPerMK');
                Route::post('/tambahPerDosen', "RemedialPelaksanaanKelasController@tambahPerDosenAjax")->name('remedial.pelaksanaan.daftar-kelas.tambahPerDosen');
            });
        });

        Route::prefix('laporan')->group(function () {
            Route::get('/', "RemedialLaporanController@index")->name('remedial.laporan');
            Route::post('/print-laporan', "RemedialLaporanController@printLaporan")->name('remedial.laporan.print');
        });
    });

    Route::prefix('sisipan')->group(function () {
        Route::get('/', "SisipanController@index")->name('sisipan');
        Route::prefix('periode')->group(function () {
            Route::prefix('prodi')->group(function () {
                Route::get('/', "SisipanPeriodeProdiController@index")->name('sisipan.periode.prodi');
                Route::post('/', "SisipanPeriodeProdiController@store")->name('sisipan.periode.prodi.store');
                Route::delete('/{id}', "SisipanPeriodeProdiController@destroy")->name('sisipan.periode.prodi.delete');
            });

            Route::prefix('tarif')->group(function () {
                Route::get('/', "SisipanPeriodeTarifController@index")->name('sisipan.periode.tarif');
                Route::post('/', "SisipanPeriodeTarifController@store")->name('sisipan.periode.tarif.store');
                Route::delete('/{id}', "SisipanPeriodeTarifController@destroy")->name('sisipan.periode.tarif.delete');
            });

            Route::get('/', "SisipanPeriodeController@index")->name('sisipan.periode');
            Route::get('/create', "SisipanPeriodeController@create")->name('sisipan.periode.create');
            Route::get('/{id}', "SisipanPeriodeController@edit")->name('sisipan.periode.edit');
            Route::post('/', "SisipanPeriodeController@store")->name('sisipan.periode.store');
            Route::post('/salin', "SisipanPeriodeController@salinPeriode")->name('sisipan.periode.salin');
            Route::put('/{id}', "SisipanPeriodeController@update")->name('sisipan.periode.update');
            Route::delete('/{id}', "SisipanPeriodeController@destroy")->name('sisipan.periode.delete');
        });

        Route::prefix('ajuan')->group(function () {
            Route::prefix('detail')->group(function () {
                Route::get('/{id}', "SisipanAjuanController@ajuandetail")->name('sisipan.ajuan.detail');
                Route::get('/data/{id}', "SisipanAjuanController@ajuandetaildata")->name('sisipan.ajuan.detaildata');
                Route::post('/', "SisipanAjuanController@ajuanDetailStore")->name('sisipan.ajuan.detail.store');
                Route::delete('/{id}', "SisipanAjuanController@detailDelete")->name('sisipan.ajuan.detail.delete');
            });
            Route::get('/verifikasi', "SisipanAjuanController@index")->name('sisipan.ajuan.verifikasi');
            Route::get('/daftar-ajuan', "SisipanAjuanController@daftarAjuan")->name('sisipan.ajuan.daftarAjuan');
            Route::post('/', "SisipanAjuanController@store")->name('sisipan.ajuan.store');
            Route::post('/upload-bukti-pembayaran', "SisipanAjuanController@uploadBukti")->name('sisipan.ajuan.uploadBukti');
            Route::post('/upload-rekening-koran', "SisipanAjuanController@uploadRekeningKoran")->name('sisipan.ajuan.uploadRekeningKoran');
            Route::post('/verifikasi-ajuan', "SisipanAjuanController@verifikasiAjuan")->name('sisipan.ajuan.verifikasiAjuan');
            Route::delete('/{id}', "SisipanAjuanController@deleteAjax")->name('sisipan.ajuan.deleteAjax');
        });

        Route::prefix('mahasiswa')->group(function () {
            Route::get('/', "SisipanMahasiswaController@index")->name('sisipan.mahasiswa');
            Route::get('/create', "SisipanMahasiswaController@create")->name('sisipan.mahasiswa.create');
            Route::get('/{id}', "SisipanMahasiswaController@edit")->name('sisipan.mahasiswa.edit');
            Route::post('/periode', "SisipanMahasiswaController@index")->name('sisipan.mahasiswa.periode');
            Route::post('/', "SisipanMahasiswaController@store")->name('sisipan.mahasiswa.store');
            Route::put('/{id}', "SisipanMahasiswaController@update")->name('sisipan.mahasiswa.update');
            Route::delete('/{id}', "SisipanMahasiswaController@destroy")->name('sisipan.mahasiswa.delete');
        });

        Route::prefix('laporan')->group(function () {
            Route::get('/', "SisipanLaporanController@index")->name('sisipan.laporan');
            Route::post('/print-laporan', "SisipanLaporanController@printLaporan")->name('sisipan.laporan.print');
        });
    });

    //test
    Route::get('/test', "TestController@index");
});
