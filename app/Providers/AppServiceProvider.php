<?php

namespace App\Providers;

use App\Repositories\Izin\IzinRepository;
use App\Repositories\Izin\IzinRepositoryImplement;
use App\Repositories\Password\PasswordRepository;
use App\Repositories\Password\PasswordRepositoryImplement;
use App\Repositories\Pegawai\PegawaiRepository;
use App\Repositories\Pegawai\PegawaiRepositoryImplement;
use App\Repositories\TotalPresensi\TotalPresensiRepository;
use App\Repositories\TotalPresensi\TotalPresensiRepositoryImplement;
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
