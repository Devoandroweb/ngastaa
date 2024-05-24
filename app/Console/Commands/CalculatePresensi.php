<?php

namespace App\Console\Commands;

use App\Jobs\CalculatePresensi as JobsCalculatePresensi;
use App\Repositories\CalculatePresensi\CalculatePresensiRepository;
use App\Repositories\TotalPresensi\TotalPresensiRepository;
use App\Traits\Whatsapp;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\File;

class CalculatePresensi extends Command
{
    use Whatsapp,Dispatchable;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'presensi:calculate-presensi';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // $this->info("Calculate Start ....");
        // $this->line("Calculate Start ....");
        
        JobsCalculatePresensi::dispatch();


    }
}
