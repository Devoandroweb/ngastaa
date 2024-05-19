<?php

namespace App\Console\Commands;

use App\Models\Pegawai\DataPresensi;
use App\Models\User;
use App\Repositories\Pegawai\PegawaiRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class SavePresensi extends Command
{
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
        $users = User::whereOwner(0)->pluck('nip')->toArray();
        foreach($users as $nip){
            Cache::forget("home-user-$nip");
        }
        $dPresensiExist = DataPresensi::whereIn('nip',$users)->whereDate('tanggal_datang', date("Y-m-d"))->pluck('nip')->toArray();
        $dPresensiNotExist = array_diff($users,$dPresensiExist);

        Cache::forever("presensi-datang-exist",$dPresensiExist);
        Cache::forever("presensi-datang-not-exist",$dPresensiNotExist);
    }
}
