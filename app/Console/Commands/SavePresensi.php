<?php

namespace App\Console\Commands;

use App\Models\Pegawai\DataPresensi;
use App\Models\User;
use App\Repositories\Pegawai\PegawaiRepository;
use App\Traits\Whatsapp;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class SavePresensi extends Command
{
    use Whatsapp;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:save-presensi';

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
    protected $pegawaiRepository;

    public function handle()
    {
        Artisan::call("presensi:clear-presensi");
        Artisan::call("presensi:reset-status");
        $users = User::whereOwner(0)->pluck('nip')->toArray();
        foreach($users as $nip){
            Cache::forget("home-user-$nip");
        }
        $dPresensiExist = DataPresensi::whereIn('nip',$users)->whereDate('tanggal_datang', date("Y-m-d"))->pluck('nip')->toArray();
        $dPresensiNotExist = array_diff($users,$dPresensiExist);

        Cache::forever("presensi-datang-exist",$dPresensiExist);
        Cache::forever("presensi-datang-not-exist",$dPresensiNotExist);

        $now = now();
        $path = public_path('cronjob.txt'); // Path file di direktori storage
        $content = "$now | Save Cache Presensi Succesfully.\n"; // Konten yang akan ditulis ke file
        // Menulis ke file
        File::put($path, $content);
        $this->sendMessage("6285745325535",$content);
    }
}
