<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\PegawaiResource;
use App\Models\User;
use App\Repositories\Pegawai\PegawaiRepository;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    protected $pegawaiRepository;
    // protected $pegawaiWithRole;
    function __construct(
        PegawaiRepository $pegawaiRepository
    ){
        $this->pegawaiRepository = $pegawaiRepository;
    }
    function listOpd(){
        try{
            $nip = request('nip');
            $kode_skpd = User::whereNip($nip)->first()->jabatan_akhir()->first()->kode_skpd;
            $pegawai = $this->pegawaiRepository->allPegawaiWithRole($kode_skpd,true)->get();
        
            return response()->json([
                'status' => TRUE,
                'message' => "Success",
                'data' => $pegawai,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => FALSE,
                'message' => "Failed",
                'data' => $th->getMessage()
            ], 404);
        };
    }
}
