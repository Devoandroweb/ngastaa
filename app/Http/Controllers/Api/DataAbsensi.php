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
            $dataPresensi = new DataPresensi;
            if(request('start_date') && request('start_date')){
                $dataPresensi = $dataPresensi->whereBetween('created_at',[request('start_date'),request('end_date')]);
            }
            $dataPresensi = $dataPresensi->where("nip",$nip)->limitOffset()->orderByDesc('created_at')->get();
            // dd($dataPresensi->toSql());
            $data = [];
            foreach ($dataPresensi as $p) {
                $hari = date("w",strtotime($p->tanggal_datang));
                $tanggalDatang = date("Y-m-d",strtotime($p->tanggal_datang));
                $tanggalPulang = date("Y-m-d",strtotime($p->tanggal_pulang));
                $data[] = [
                    'tanggal' => hari($hari) . ", " .tanggal_indo($tanggalDatang),
                    'absen' => date("H:i",strtotime($p->tanggal_datang)),
                    'status' => 1,
                ];
                $data[] = [
                    'tanggal' => hari($hari) . ", " .tanggal_indo($tanggalPulang),
                    'absen' => date("H:i",strtotime($p->tanggal_pulang)),
                    'status' => 2,
                ];

            }
            return response()->json([
                'status' => TRUE,
                'message' => "Success",
                'totalData' => $dataPresensi->count(),
                'data' => $data,
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
