<?php

namespace App\Console\Commands;

use App\Models\AppStatusFunction;
use App\Models\Pegawai\RiwayatJamKerja;
use App\Repositories\TotalPresensi\TotalPresensiRepository;
use Illuminate\Console\Command;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\DB;

class Presensi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'presensi:calculate';

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
        try {

            DB::transaction(function(){
                // $this->totalPresensiRepository->calculatePresensi();
            });
            DB::commit();
            $file = fopen('cronjob.txt','a');
            fwrite($file, "Sukses hitung ".now());
            // fwrite($file, "run command berhasil");
            fclose($file);
            $this->info("Sukses hitung ".now());
            //code...
        } catch (\Throwable $th) {
            $fileError = fopen('error_cronjob.txt','a');
            fwrite($fileError, $th->getMessage() ." | file : ".$th->getFile()." | line : ".$th->getLine()." | ". now());
            // fwrite($fileError, "run command berhasil");
            fclose($fileError);
            //throw $th;
            $this->info($th->getMessage() ." | file : ".$th->getFile()." | line : ".$th->getLine()." | ". now());
            DB::rollBack();
        }
        return Command::SUCCESS;
    }
}
