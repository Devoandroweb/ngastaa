<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pegawai\DataPresensi;
use App\Models\User;
use Illuminate\Http\Request;

class Presensi extends Controller
{
    function index($nip){
        try {

            $data = DataPresensi::where('nip', $nip)->whereDate('created_at', date('Y-m-d'))->first();
            if($data != null){

                $data = [
                    'nip' => $nip,
                    'datang' => $data->tanggal_datang != null ? date("H:i:s",strtotime($data->tanggal_datang)) : "-",
                    'istirahat' => $data->tanggal_istirahat != null ? date("H:i:s",strtotime($data->tanggal_istirahat)) : "-",
                    'pulang' => $data->tanggal_pulang != null ? date("H:i:s",strtotime($data->tanggal_pulang)) : "-",
                    'visit' => "-",
                ];
            }else{
                $data = [
                    'nip' => $nip,
                    'datang' => "-",
                    'istirahat' => "-",
                    'pulang' => "-",
                    'visit' => "-",
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
        }

    }
    function checkStatusAbsen($nip)
    {
        try{
            $pegawai = User::where('nip',$nip)->first();
            $data['status'] = true;
            if($pegawai->status_absen == 1){
                $data['absen_status'] = true;
                return response()->json([
                    'status' => TRUE,
                    'message' => "Success",
                    'data' => $data
                ], 200);
            }else{
                $data['absen_status'] = false;
                return response()->json([
                    'status' => TRUE,
                    'message' => "Success",
                    'data' => $data
                ], 200);
            }
        } catch (\Throwable $th) {
            $data['status'] = null;
            $data['absen_status'] = null;
            return response()->json([
                'status' => TRUE,
                'message' => "Failed",
                'data' => $data
            ], 400);
        }
    }
}
