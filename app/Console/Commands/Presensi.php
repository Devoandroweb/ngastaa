<?php

namespace App\Console\Commands;

use App\Models\AppStatusFunction;
use App\Repositories\TotalPresensi\TotalPresensiRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Presensi extends Command
{
    protected $totalPresensiRepository;
    function __construct(TotalPresensiRepository $totalPresensiRepository)
    {
        $this->totalPresensiRepository = $totalPresensiRepository;
    }
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
    public function handle()
    {
        try {
            DB::transaction(function(){
                $this->totalPresensiRepository->calculatePresensi();
                // $resultCalculate = $this->totalPresensiRepository->manualCaculate();
            });
            DB::commit();
            //code...
        } catch (\Throwable $th) {
            $fileError = fopen('error_cronjob.txt','a');
            fwrite($fileError, $th->getMessage() ." | file : ".$th->getFile()." | line : ".$th->getLine()." | ". now());
            // fwrite($fileError, "run command berhasil");
            fclose($fileError);
            //throw $th;
            DB::rollBack();
        }
        return Command::SUCCESS;
    }
}
