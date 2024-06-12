<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class ClearPresensi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'presensi:clear-presensi';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $date = date("Y-m-d",strtotime("-1 Days"));
        Cache::forget("presensi-datang-$date");
        Cache::forget("presensi-pulang-$date");
        Cache::forget("presensi-datang-exist-$date");
        Cache::forget("presensi-datang-not-exist-$date");
        $now = now();
        $path = public_path('cronjob.txt'); // Path file di direktori storage
        $content = "$now | Clear Cache Presensi Succesfully.\n"; // Konten yang akan ditulis ke file

        // Menulis ke file
        File::put($path, $content);
    }
}
