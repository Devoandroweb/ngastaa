<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pegawai\DataPresensi;
use Illuminate\Http\Request;

class Presensi extends Controller
{
    function index($nip){
        try {

            $data = DataPresensi::where('nip', $nip)->whereDate('created_at', date('Y-m-d'))->first();
         
            $data = [
                'nip' => $nip,
                'datang' => $data ? date("H:i:s",strtotime($data->tanggal_datang)) : "-",
                'pulang' => $data ? date("H:i:s",strtotime($data->tanggal_pulang)) : "-",
            ];
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
