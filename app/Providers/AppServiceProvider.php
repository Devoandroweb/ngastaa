<?php

namespace App\Providers;

use App\Repositories\Izin\IzinRepository;
use App\Repositories\Izin\IzinRepositoryImplement;
use App\Repositories\Password\PasswordRepository;
use App\Repositories\Password\PasswordRepositoryImplement;
use App\Repositories\Pegawai\PegawaiRepository;
use App\Repositories\Pegawai\PegawaiRepositoryImplement;
use App\Repositories\Pengumuman\PengumumanRepository;
use App\Repositories\Pengumuman\PengumumanRepositoryImplement;
use App\Repositories\Presensi\PresensiRepository;
use App\Repositories\Presensi\PresensiRepositoryImplement;
use App\Repositories\TotalPresensi\TotalPresensiRepository;
use App\Repositories\TotalPresensi\TotalPresensiRepositoryImplement;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryImplement;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(TotalPresensiRepository::class,TotalPresensiRepositoryImplement::class);
        $this->app->bind(PegawaiRepository::class,PegawaiRepositoryImplement::class);
        $this->app->bind(IzinRepository::class,IzinRepositoryImplement::class);
        $this->app->bind(PasswordRepository::class,PasswordRepositoryImplement::class);
        $this->app->bind(UserRepository::class,UserRepositoryImplement::class);
        $this->app->bind(PresensiRepository::class,PresensiRepositoryImplement::class);
        $this->app->bind(PengumumanRepository::class,PengumumanRepositoryImplement::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
