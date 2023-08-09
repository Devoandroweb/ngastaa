<?php

namespace App\Providers;

use App\Repositories\Divisi\DivisiRepository;
use App\Repositories\Divisi\DivisiRepositoryImplement;
use App\Repositories\Izin\IzinRepository;
use App\Repositories\Izin\IzinRepositoryImplement;
use App\Repositories\JamKerja\JamKerjaRepository;
use App\Repositories\JamKerja\JamKerjaRepositoryImplement;
use App\Repositories\LokasiKerja\LokasiKerjaRepository;
use App\Repositories\LokasiKerja\LokasiKerjaRepositoryImplement;
use App\Repositories\Password\PasswordRepository;
use App\Repositories\Password\PasswordRepositoryImplement;
use App\Repositories\Payroll\PayrollRepository;
use App\Repositories\Payroll\PayrollRepositoryImplement;
use App\Repositories\Pdf\PdfRepository;
use App\Repositories\Pdf\PdfRepositoryImplement;
use App\Repositories\Pegawai\PegawaiRepository;
use App\Repositories\Pegawai\PegawaiRepositoryImplement;
use App\Repositories\Pengumuman\PengumumanRepository;
use App\Repositories\Pengumuman\PengumumanRepositoryImplement;
use App\Repositories\Presensi\PresensiRepository;
use App\Repositories\Presensi\PresensiRepositoryImplement;
use App\Repositories\Shift\ShiftRepository;
use App\Repositories\Shift\ShiftRepositoryImplement;
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
        $this->app->bind(PayrollRepository::class,PayrollRepositoryImplement::class);
        $this->app->bind(DivisiRepository::class,DivisiRepositoryImplement::class);
        $this->app->bind(JamKerjaRepository::class,JamKerjaRepositoryImplement::class);
        $this->app->bind(PdfRepository::class,PdfRepositoryImplement::class);
        $this->app->bind(ShiftRepository::class,ShiftRepositoryImplement::class);
        $this->app->bind(LokasiKerjaRepository::class,LokasiKerjaRepositoryImplement::class);
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
