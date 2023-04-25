<?php

namespace App\Http\Controllers;

use App\Models\AppStatusFunction;
use App\Repositories\TotalPresensi\TotalPresensiRepository;
use Illuminate\Http\Request;

class CCronjobs extends Controller
{
    protected $totalPresensiRepository;
    function __construct(TotalPresensiRepository $totalPresensiRepository)
    {   
        $this->totalPresensiRepository = $totalPresensiRepository;
    }
    function calculatePresensi(){
        try {
            $resultCalculate = $this->totalPresensiRepository->calculatePresensi();
            if ($resultCalculate == 0) {
                return response()->json([
                    'status' => FALSE,
                    'message' => 'Maaf Perhitungan Presensi untuk hari ini sebelumnya sudah di hitung'
                ]);
            }
            return response()->json([
                'status' => TRUE,
                'message' => 'Berhasil menghitung presensi untuk hari ini, silahkan klik link berikut untuk meninjau perhitungan, <br>
                <a href="'.route("presensi.total_presensi.index").'">Tinjau</a>'
            ]);
        } catch (\Throwable $th) {
            // return report($th->getMessage());
            return response()->json([
                'status' => FALSE,
                'message' => 'Gagal Menghitung Presensi untuk hari ini dengan Error : '.$th->getMessage()
            ]);
        }
    }
    function resetAppStatusCalculatePresensi(){
        try{
            $value = AppStatusFunction::where('name','calculate_presensi')->first();
            $value->value = 0;
            $value->update();
            return response()->json([
                'status' => TRUE,
                'message' => 'Reset Sukses'
            ]);
        } catch (\Throwable $th) {
            // return report($th->getMessage());
            return response()->json([
                'status' => FALSE,
                'message' => 'Reset Gagal dengan Error : '.$th->getMessage()
            ]);
        }

    }
}
