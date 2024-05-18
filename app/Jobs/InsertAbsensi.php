<?php

namespace App\Jobs;

use App\Models\Pegawai\DataPresensi;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class InsertAbsensi implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
        $pd = Cache::get("presensi-datang");
        $pp = Cache::get("presensi-pulang");

        $datasPd = collect($pd);
        $datasPp = collect($pp);
        $datas = [];
        foreach ($datasPd as $key => $data) {
            $datas[] = collect($data)->merge($datasPp[$key])->unique()->toArray();
        }
        DataPresensi::insert($datas);
        
    }
}
