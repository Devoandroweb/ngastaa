<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pegawai\RiwayatBahasa;
use App\Repositories\PenguasaanBahasa\PenguasaanBahasaRepository;
use Illuminate\Http\Request;

class PenguasaanBahasaController extends Controller
{
    private $penguasaanBahasaRepository;
    function __construct(PenguasaanBahasaRepository $penguasaanBahasaRepository) {
        $this->penguasaanBahasaRepository = $penguasaanBahasaRepository;
    }
    function list(){
        try{
            $data = $this->penguasaanBahasaRepository->list();
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
        $cr = $this->penguasaanBahasaRepository->store();
        $message = $this->penguasaanBahasaRepository->getMessage();
        if ($cr) {
            return response()->json(["status"=>true,"msg"=>"Berhasil, $message!"]);
        } else {
            return response()->json(["status"=>false,"msg"=>"Gagal, $message!"]);
        }
    }
    function delete(RiwayatBahasa $riwayatBahasa){
        $cr = $this->penguasaanBahasaRepository->delete($riwayatBahasa);
        if ($cr) {
            return response()->json(["status"=>true,"msg"=>"Berhasil, di Hapus!"]);
        } else {
            return response()->json(["status"=>false,"msg"=>"Gagal, di Hapus!"]);
        }
    }
}
