<?php

namespace App\Console\Commands;

use App\Models\AppStatusFunction;
use Illuminate\Console\Command;

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
    protected $description = 'Menhitung Presensi Harian untuk di masukkan ke Rekap Presensi';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // $value = AppStatusFunction::where('name','calculate_presensi')->first();
        // $value->value = 0;
        // $value->update();
        $fileError = fopen('error_cronjob.txt','a');
        // fwrite($fileError, $th->getMessage() ." | file : ".$th->getFile()." | line : ".$th->getLine()." | ". now());
        fwrite($fileError, "run command berhasil");
        fclose($fileError);
        return Command::SUCCESS;
    }
}
