<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pegawai\DataPresensi;
use App\Models\User;
use App\Repositories\Presensi\PresensiRepository;
use Illuminate\Http\Request;

class Presensi extends Controller
{
    protected $presensiRepository;
    function __construct(
        PresensiRepository $presensiRepository
    ){
        $this->presensiRepository = $presensiRepository;

    }
    function index($nip){
        try {
            return response()->json([
                'status' => TRUE,
                'message' => "Success",
                'data' => $this->presensiRepository->presensiDay($nip)
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
            $presensiPegawai = DataPresensi::where('nip',$nip)->whereDate('created_at', '=', date("Y-m-d"))->first();
            $data['status'] = true;
            if($presensiPegawai != null){
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
                'status' => false,
                'message' => "Failed",
                'data' => $data
            ], 400);
        }
    }
}
