<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pegawai\RiwayatPmk;
use App\Repositories\PengalamanKerja\PengalamanKerjaRepository;
use Illuminate\Http\Request;

class PengalamanKerjaController extends Controller
{
    private $pengalamanKerjaRepository;
    function __construct(PengalamanKerjaRepository $pengalamanKerjaRepository) {
        $this->pengalamanKerjaRepository = $pengalamanKerjaRepository;
    }
    function list(){
        try{
            $data = $this->pengalamanKerjaRepository->list();
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
    function store(){
        $cr = $this->pengalamanKerjaRepository->store();
        $message = $this->pengalamanKerjaRepository->getMessage();
        if ($cr) {
            return response()->json(["status"=>true,"msg"=>"Berhasil, $message!"]);
        } else {
            return response()->json(["status"=>false,"msg"=>"Gagal, $message!"]);
        }
    }
    function delete(RiwayatPmk $riwayatPmk){
        $cr = $this->pengalamanKerjaRepository->delete($riwayatPmk);
        if ($cr) {
            return response()->json(["status"=>true,"msg"=>"Berhasil, di Hapus"]);
        } else {
            return response()->json(["status"=>false,"msg"=>"Gagal, di Hapus"]);
        }
    }
}
