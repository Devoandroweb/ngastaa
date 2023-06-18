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
    public function handle()
    {
        try {
            $pegawai = User::all();
            foreach ($pegawai as $value) {
                RiwayatJamKerja::create([
                    'nip' => $value->nip,
                    'kode_jam_kerja' => 'JM-01HODSM',
                    'is_akhir' => 1,
                    'status' => 1
                ]);
            }

            DB::transaction(function(){
                \App\Repositories\TotalPresensi\TotalPresensiRepository::calculatePresensi();
                // $resultCalculate = $this->totalPresensiRepository->manualCaculate();
            });
            DB::commit();
            $file = fopen('cronjob.txt','a');
            fwrite($file, "Sukses hitung ".now());
            // fwrite($file, "run command berhasil");
            fclose($file);
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
