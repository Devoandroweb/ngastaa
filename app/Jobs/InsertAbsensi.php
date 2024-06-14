<?php

namespace App\Jobs;

use App\Models\Pegawai\DataPresensi;
use App\Traits\Whatsapp;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class InsertAbsensi implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Whatsapp;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        #  run in clock 02:00
        $date = date("Y-m-d",strtotime("-1 Days"));

        if(!Cache::get("presensi-insert-status-$date")){
            $datas = getPresensi($date);
            foreach ($datas as $data) {
                $tanggal = date("Y-m-d",strtotime($data["tanggal_datang"]));
                $dataPresensi = DataPresensi::whereNip($data["nip"])->whereDate("tanggal_datang",$tanggal)->first();
                if($dataPresensi){
                    $dataPresensi->update($data);
                }else{
                    DataPresensi::create($data);
                }
            }
            Cache::forever("presensi-insert-status-$date",true);
            Artisan::call("presensi:clear-presensi");
            $now = now();
            $path = public_path('cronjob.txt'); // Path file di direktori storage
            $content = "$now | Insert Presensi Succesfully.\n"; // Konten yang akan ditulis ke file
            // Menulis ke file
            File::append($path, $content);
            $this->sendMessage("6285745325535",$content);
        }
    }
}
