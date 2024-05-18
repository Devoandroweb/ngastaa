<?php

namespace App\Console\Commands;

use App\Jobs\InsertAbsensi;
use App\Models\Pegawai\DataPresensi;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class InsertPresensi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:insert-presensi';

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
        // InsertAbsensiDatang::dispatch();
        InsertAbsensi::dispatch();
    }
}
