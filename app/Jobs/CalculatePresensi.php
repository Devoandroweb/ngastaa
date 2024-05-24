<?php

namespace App\Jobs;

use App\Models\Presensi\TotalPresensiDetail;
use App\Repositories\CalculatePresensi\CalculatePresensiRepository;
use App\Repositories\TotalPresensi\TotalPresensiRepository;
use App\Traits\Whatsapp;
use App\Traits\CalculatePresensiTraits;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CalculatePresensi implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Whatsapp, CalculatePresensiTraits;
    protected $dataCalculate;
    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $resultCalculate = app(CalculatePresensiRepository::class);
        $resultCalculate = $resultCalculate->manualCalculate();
        foreach ($resultCalculate as $data) {
            TotalPresensiDetail::firstOrCreate($data);
        }
    }
}
