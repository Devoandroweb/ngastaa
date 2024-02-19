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
            $data = RiwayatPendidikan::all();
            $data = RiwayatPendidikanResource::collection($data);
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
            $data = Pendidikan::orderBy('kode_pendidikan','desc')->get();
            $data = PendidikanResource::collection($data);
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
            $data = Jurusan::where('kode_pendidikan',$kode_pendidikan)->orderBy('nama','asc')->get();
            $data = JurusanResource::collection($data);
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
        if(request()->query("for") == 0){
            if ($cr) {
                return response()->json(["status"=>true,"msg"=>"Berhasil, ditambahkan!"]);
            } else {
                return response()->json(["status"=>false,"msg"=>"Gagal, ditambahkan!"]);
            }
        }else{
            if ($cr) {
                return response()->json(["status"=>true,"msg"=>"Berhasil, diperbarui!"]);
            } else {
                return response()->json(["status"=>false,"msg"=>"Gagal, diperbarui!"]);
            }
        }
    }
}
