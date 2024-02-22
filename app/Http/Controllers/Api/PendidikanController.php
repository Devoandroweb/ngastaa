<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Master\JurusanResource;
use App\Http\Resources\Master\PendidikanResource;
use App\Http\Resources\Pegawai\RiwayatPendidikanResource;
use App\Models\Master\Jurusan;
use App\Models\Master\Pendidikan;
use App\Models\Pegawai\RiwayatPendidikan;
use App\Repositories\Pendidikan\PendidikanRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PendidikanController extends Controller
{
    private $pendidikanRepository;
    function __construct(PendidikanRepository $pendidikanRepository) {
        $this->pendidikanRepository = $pendidikanRepository;

    }
    function list(){
        try{
            $data = $this->pendidikanRepository->list();
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
    function listTingkatPendidikan() : JsonResponse {
        try{
            $data = $this->pendidikanRepository->listTingkatPendidikan();
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
    function listJurusanPendidikan($kode_pendidikan) : JsonResponse {
        try{
            $data = $this->pendidikanRepository->listJurusanPendidikan($kode_pendidikan);
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
        $cr = $this->pendidikanRepository->store();
        $message = $this->pendidikanRepository->getMessage();
        if ($cr) {
            return response()->json(["status"=>true,"msg"=>"Berhasil, $message!"]);
        } else {
            return response()->json(["status"=>false,"msg"=>"Gagal, $message!"]);
        }
    }
    function delete(RiwayatPendidikan $riwayatPendidikan){
        $cr = $this->pendidikanRepository->delete($riwayatPendidikan);
        if ($cr) {
            return response()->json(["status"=>true,"msg"=>"Berhasil, di Hapus!"]);
        } else {
            return response()->json(["status"=>false,"msg"=>"Gagal, di Hapus!"]);
        }
    }
}
