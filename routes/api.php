<?php

use App\Http\Controllers\Api\ApiDivisiController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CApiAktifitas;
use App\Http\Controllers\Api\CutiApiController;
use App\Http\Controllers\Api\DataAbsensi;
use App\Http\Controllers\Api\HomeUser;
use App\Http\Controllers\Api\Keluarga\SemuaKeluargaController;
use App\Http\Controllers\Api\KursusKontroller;
use App\Http\Controllers\Api\LemburApiController;
use App\Http\Controllers\Api\OrganisasiController;
use App\Http\Controllers\Api\PayrollApiController;
use App\Http\Controllers\Api\PegawaiController;
use App\Http\Controllers\Api\PendidikanController;
use App\Http\Controllers\Api\PengalamanKerjaController;
use App\Http\Controllers\Api\PenguasaanBahasaController;
use App\Http\Controllers\Api\PengumumanApiController;
use App\Http\Controllers\Api\PerusahaanApiController;
use App\Http\Controllers\Api\Presensi;
use App\Http\Controllers\Api\PresensiApiController;
use App\Http\Controllers\Api\ReimbursementApiController;
use App\Http\Controllers\Api\ShiftApiController;
use App\Http\Controllers\Api\User;
use App\Http\Controllers\Api\VisitApiController;
use App\Http\Controllers\CCronjobs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('login', [AuthController::class, 'login']);
Route::controller(CCronjobs::class)
        ->group(function(){
            Route::get('calculate-presensi','calculatePresensi')->name('calculate-presensi');
        });

Route::middleware(['auth:sanctum','validateToken'])->group(function(){

    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('getUser', [AuthController::class, 'getUser']);
    Route::post('register-face-recognition', [User::class, 'registerFaceRecognition']);
    Route::post('check-face-recognition', [User::class, 'checkFaceRecognition']);
    Route::post('ubah-password', [AuthController::class,'changePassword']);
    Route::post('ubah-alamat', [User::class,'changeAddress']);
    Route::post('password-check', [AuthController::class,'passwordCheck']);
    Route::post('home-user', [HomeUser::class,'index']);
    Route::get('riwayat-presensi/{nip}', [DataAbsensi::class,'index']);
    Route::get('total-presensi/{nip}', [DataAbsensi::class,'totalAbasensi']);
    Route::get('profil/{nip}', [User::class,'index']);
    Route::get('profil-detail/{nip}', [User::class,'detail']);
    Route::post('edit-profil', [User::class,'updateProfile']);
    Route::get('absen/{nip}', [Presensi::class,'index']);
    Route::get('check-status-absen/{nip}', [Presensi::class,'checkStatusAbsen']);
    Route::get('list-lokasi-visit', [VisitApiController::class,'list_lokasi_visit']);

    Route::controller(AuthController::class)
        ->prefix('whatsapp')
        ->name('whatsapp.')
        ->group(function(){
            Route::get('check-no-wa', 'checkWAVerif');
            Route::post('send-otp', 'sendWAOtp');
            Route::post('save-otp', 'saveOtp');
        });

    Route::controller(PegawaiController::class)
        ->prefix('pegawai')
        ->name('pegawai.')
        ->group(function(){
            Route::get('list-opd', 'listOpd');
        });

    Route::controller(PerusahaanApiController::class)
        ->prefix('perusahaan')
        ->name('perusahaan.')
        ->group(function(){
            Route::get('', 'index');
        });
    Route::controller(CApiAktifitas::class)
        ->prefix('aktifitas')
        ->name('aktifitas.')
        ->group(function(){
            Route::get('', 'index');
            Route::post('store', 'store');
            Route::get('lists-opd', 'listOpd');
            Route::post('checkout', 'checkOut');
        });

    Route::controller(PresensiApiController::class)
        ->prefix('presensi')
        ->name('presensi.')
        ->group(function(){
            Route::get('', 'index');
            Route::post('store', 'store');
            Route::get('lists', 'lists');
            Route::get('lists-opd', 'listsOpd');
            Route::get('shift', 'shift');
            Route::get('lokasi', 'lokasi');
            Route::get('existing-presensi-day/{nip}', 'existingAbsenDay');
            Route::post('statistik', 'statistikPresensi');
        });

    Route::controller(VisitApiController::class)
        ->prefix('visit')
        ->name('visit.')
        ->group(function(){
            Route::get('', 'index');
            Route::get('lokasi', 'lokasi');
            Route::post('store', 'store');
            Route::post('check-out', 'checkOut');
        });

    Route::controller(PengumumanApiController::class)
        ->prefix('pengumuman')
        ->name('pengumuman.')
        ->group(function(){
            Route::get('', 'index');
            Route::get('detail/{pengumuman}', 'detail');
            Route::get('count', 'count');
        });

    Route::controller(PayrollApiController::class)
        ->prefix('payroll-client')
        ->name('payroll-client.')
        ->group(function(){
            Route::get('', 'index');
            Route::get('detail', 'detail');
        });

    Route::controller(ApiDivisiController::class)
        ->prefix('divisi')
        ->name('divisi.')
        ->group(function(){
            Route::get('list', 'list');
        });

    Route::prefix('pengajuan')
        ->group(function () {

        Route::controller(CutiApiController::class)
            ->prefix('cuti')
            ->group(function () {
                Route::get('',  'index');
                Route::get('lists', 'lists');
                Route::get('lists-opd', 'listsOpd');
                Route::post('store', 'store');
                Route::get('detail',  'detail');
                Route::post('approval',  'approval');
            });

        Route::controller(LemburApiController::class)
            ->prefix('lembur')
            ->group(function () {
                Route::get('lists', 'lists');
                Route::get('lists-opd', 'listsOpd');
                Route::post('store',  'store');
                Route::get('detail',  'detail');
            });

        Route::controller(ReimbursementApiController::class)
            ->prefix('reimbursement')
            ->group(function () {
                Route::get('',  'index');
                Route::get('lists', 'lists');
                Route::post('store', 'store');
                Route::get('detail',  'detail');
            });
        Route::controller(ShiftApiController::class)
            ->prefix('shift')
            ->group(function () {
                Route::get('',  'index');
                Route::get('lists', 'lists');
                Route::get('lists-opd', 'listsOpd');
                Route::post('store', 'store');
                Route::get('detail',  'detail');
                Route::get('list-master-shift/{nip}', 'listMasterShift');
                Route::post('ubah-shift', 'storeUbahShift');

            });
    });

    Route::prefix('keluarga')
        ->name('keluarga.')
        ->group(function(){
            Route::prefix('semua')
                ->name('semua.')
                ->controller(SemuaKeluargaController::class)
                ->group(function(){
                    Route::get('list', 'list');
                    Route::post('store', 'store');
                    Route::get('delete/{keluarga}', 'delete');
                });
        });
    Route::prefix('pendidikan')
        ->name('pendidikan.')
        ->controller(PendidikanController::class)
        ->group(function(){
            Route::get('list', 'list');
            Route::get('list-master-pendidikan', 'listTingkatPendidikan');
            Route::get('list-jurusan/{id_pendidikan}', 'listJurusanPendidikan');
            Route::post('store', 'store');
            Route::get('delete/{riwayatPendidikan}', 'delete');
        });
    Route::prefix('kursus')
        ->name('kursus.')
        ->controller(KursusKontroller::class)
        ->group(function(){
            Route::get('list', 'list');
            Route::get('list-master-kursus', 'listMasterKursus');
            Route::post('store', 'store');
            Route::get('delete/{riwayatKursus}', 'delete');

        });
    Route::prefix('organisasi')
        ->name('organisasi.')
        ->controller(OrganisasiController::class)
        ->group(function(){
            Route::get('list', 'list');
            Route::post('store', 'store');
            Route::get('delete/{riwayatOrganisasi}', 'delete');
        });
    Route::prefix('pengusaan-bahasa')
        ->name('pengusaan-bahasa.')
        ->controller(PenguasaanBahasaController::class)
        ->group(function(){
            Route::get('list', 'list');
            Route::post('store', 'store');
            Route::get('delete/{riwayatBahasa}', 'delete');
        });
    Route::prefix('pengalaman-kerja')
        ->name('pengalaman-kerja.')
        ->controller(PengalamanKerjaController::class)
        ->group(function(){
            Route::get('list', 'list');
            Route::post('store', 'store');
            Route::get('delete/{riwayatPmk}', 'delete');
        });
});
