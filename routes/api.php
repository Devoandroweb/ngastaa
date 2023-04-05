<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CutiApiController;
use App\Http\Controllers\Api\DataAbsensi;
use App\Http\Controllers\Api\HomeUser;
use App\Http\Controllers\Api\LemburApiController;
use App\Http\Controllers\Api\PayrollApiController;
use App\Http\Controllers\Api\PengumumanApiController;
use App\Http\Controllers\Api\PerusahaanApiController;
use App\Http\Controllers\Api\Presensi;
use App\Http\Controllers\Api\PresensiApiController;
use App\Http\Controllers\Api\ReimbursementApiController;
use App\Http\Controllers\Api\ShiftApiController;
use App\Http\Controllers\Api\User;
use App\Http\Controllers\Api\VisitApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function(){
    
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('getUser', [AuthController::class, 'getUser']);
    Route::post('ubah-password', [AuthController::class,'changePassword']);
    Route::post('password-check', [AuthController::class,'passwordCheck']);
    Route::post('home-user', [HomeUser::class,'index']);
    Route::get('riwayat-presensi/{nip}', [DataAbsensi::class,'index']);
    Route::get('total-presensi/{nip}', [DataAbsensi::class,'totalAbasensi']);
    Route::get('profil/{nip}', [User::class,'index']);
    Route::get('profil-detail/{nip}', [User::class,'detail']);
    Route::post('edit-profil', [User::class,'updateProfile']);
    Route::get('absen/{nip}', [Presensi::class,'index']);
    Route::get('list-lokasi-visit', [VisitApiController::class,'list_lokasi_visit']);

    Route::controller(PerusahaanApiController::class)
        ->prefix('perusahaan')
        ->name('perusahaan.')
        ->group(function(){
            Route::get('', 'index');
        });

    Route::controller(PresensiApiController::class)
        ->prefix('presensi')
        ->name('presensi.')
        ->group(function(){
            Route::get('', 'index');
            Route::post('store', 'store');
            Route::get('lists', 'lists');
            Route::get('shift', 'shift');
            Route::get('lokasi', 'lokasi');
            Route::get('laporan', 'laporan');
        });

    Route::controller(VisitApiController::class)
        ->prefix('visit')
        ->name('visit.')
        ->group(function(){
            Route::get('', 'index');
            Route::get('lokasi', 'lokasi');
            Route::post('store', 'store');
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
        });

    Route::prefix('pengajuan')
        ->group(function () {

        Route::controller(CutiApiController::class)
            ->prefix('cuti')
            ->group(function () {
                Route::get('',  'index');
                Route::get('lists', 'lists');
                Route::post('store', 'store');
                Route::get('detail',  'detail');
            });

        Route::controller(LemburApiController::class)
            ->prefix('lembur')
            ->group(function () {
                Route::get('lists', 'lists');
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
                Route::post('store', 'store');
                Route::get('detail',  'detail');
            });
    });

});
