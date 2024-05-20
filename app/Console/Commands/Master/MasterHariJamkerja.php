<?php

namespace App\Console\Commands\Master;

use App\Models\HariJamKerja;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class MasterHariJamkerja extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'init:master-jam-kerja';
    protected $column = ['kode_jam_kerja','tipe','hari','parent','jam_buka_datang','jam_tepat_datang','jam_tutup_datang','jam_buka_pulang','jam_tepat_pulang','jam_tutup_pulang'];

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
        $hariJamKerja = HariJamKerja::get($this->column)->toArray();
        Cache::forever("master-jam-kerja",$hariJamKerja);
    }
}
