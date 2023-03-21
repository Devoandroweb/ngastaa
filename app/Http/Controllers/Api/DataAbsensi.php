<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pegawai\DataPresensi;
use App\Models\Presensi\TotalIzin;
use App\Models\Presensi\TotalPresensi;
use Illuminate\Http\Request;

class DataAbsensi extends Controller
{
    function index($nip)
    {
        
        try {
            $dataPresensi = DataPresensi::where("nip",$nip)->get();
            $data = [];
            foreach ($dataPresensi as $p) {
                $hari = date("w",strtotime($p->created_at));
                $tanggal = date("Y-m-d",strtotime($p->created_at));
                $data[] = [
                    'tanggal' => hari($hari) . ", " .tanggal_indo($tanggal),
                    'absen' => $p->tanggal_datang,
                    'status' => 1,
                ];
                $data[] = [
                    'tanggal' => hari($hari) . ", " .tanggal_indo($tanggal),
                    'absen' => $p->tanggal_pulang,
                    'status' => 2,
                ];
            
            }
            return response()->json([
                'status' => TRUE, 
                'message' => "Success",
                'data' => $data
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => FALSE,
                'message' => "Failed",
                'data' => $th->getMessage()
            ], 404);
        };
    }
    function totalAbasensi($nip){
        try {
            $periodeBulan = date("Y-m");
            $totalPresensi = TotalPresensi::where('nip',$nip)->where('periode_bulan',$periodeBulan)->first();
            $totalIzin = TotalIzin::where('nip',$nip)->where('periode_bulan',$periodeBulan)->first();

            $data = [
                'masuk' => 0,
                'telat' => 0,
                'alfa' => 0,
                'izin' => 0,
            ];
            if(!is_null($totalPresensi)){
                $data['masuk'] = $totalPresensi->masuk;
                $data['telat'] = $totalPresensi->telat;
                $data['alfa'] = $totalPresensi->alfa;
            }
            if(!is_null($totalIzin)){
                $data['izin'] = $totalIzin->total;
            }
            return response()->json([
                'status' => TRUE, 
                'message' => "Success",
                'data' => $data
            ], 200);
        } catch (\Throwable $th) {
             return response()->json([
                'status' => FALSE,
                'message' => "Failed",
                'data' => $th->getMessage()
            ], 404);
        }
    }
}
