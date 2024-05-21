<?php

namespace App\Console\Commands;

use App\Models\AppStatusFunction;
use App\Models\Pegawai\RiwayatJamKerja;
use App\Repositories\TotalPresensi\TotalPresensiRepository;
use Illuminate\Console\Command;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Presensi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'presensi:reset-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menghitung Presensi Harian untuk di masukkan ke Rekap Presensi';

    /**
     * Execute the console command.
     *
     * @return int
     */
    // protected $totalPresensiRepository;
    // function __construct(TotalPresensiRepository $totalPresensiRepository){
    //     $this->totalPresensiRepository = $totalPresensiRepository;
    // }

    public function handle()
    {
        Cache::forget("presensi-insert-status");
        Cache::forever("presensi-insert-status",false);
    }
}
