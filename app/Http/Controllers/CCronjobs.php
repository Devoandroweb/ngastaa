<?php

namespace App\Http\Controllers;

use App\Models\AppStatusFunction;
use App\Repositories\TotalPresensi\TotalPresensiRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CCronjobs extends Controller
{
    protected $totalPresensiRepository;
    function __construct(TotalPresensiRepository $totalPresensiRepository)
    {
        $this->totalPresensiRepository = $totalPresensiRepository;
    }
    function calculatePresensi(){

        try {
            DB::transaction(function(){
                $resultCalculate = $this->totalPresensiRepository->calculatePresensi();
                // $resultCalculate = $this->totalPresensiRepository->manualCaculate();

                if ($resultCalculate == 0) {
                    return response()->json([
                        'status' => FALSE,
                        'message' => 'Maaf Perhitungan Presensi untuk hari ini sebelumnya sudah di hitung'
                    ]);
                }
            });
            DB::commit();
            return response()->json([
                'status' => TRUE,
                'message' => 'Berhasil menghitung presensi untuk hari ini, silahkan klik link berikut untuk meninjau perhitungan, <br>
                <a href="'.route("presensi.total_presensi.index").'">Tinjau</a>'
            ]);
            // $resultCalculate = $this->totalPresensiRepository->calculatePresensi();

        } catch (\Throwable $th) {
            // return report($th->getMessage());
            // DB::rollBack();

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
