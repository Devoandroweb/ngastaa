<?php

namespace App\Http\Controllers\Api\Keluarga;

use App\Http\Controllers\Controller;
use App\Http\Resources\KeluargaResource;
use App\Models\Pegawai\Keluarga;
use App\Models\User;
use App\Repositories\Keluarga\KeluargaRepository;
use Illuminate\Http\Request;

class SemuaKeluargaController extends Controller
{
    private $keluargaRepository;
    private $nip;
    function __construct(KeluargaRepository $keluargaRepository) {
        $this->keluargaRepository = $keluargaRepository;
    }
    function list(){
        try {
            // $nip = request()->user()->nip;
            $status = request('status');

            switch ($status) {
                case 'orang-tua':
                    $data = $this->keluargaRepository->orangTuaList();
                    break;
                case 'pasangan':
                    $data = $this->keluargaRepository->pasanganList();
                    break;
                case 'anak':
                    $data = $this->keluargaRepository->anakList();
                    break;
                default:
                    $data = $this->keluargaRepository->semuaKeluargaList();
                    break;
            }

            $data = KeluargaResource::collection($data);
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
        if($this->keluargaRepository->checkKeluarga(request('status'))){
            return response()->json(buildResponseGagal(['status' => 'Failed', 'messages' => 'Status Keluarga sudah ada!']),200);
        };
        $cr = $this->keluargaRepository->store();
        $message = $this->keluargaRepository->getMessage();
        if ($cr) {
            return response()->json(buildResponseSukses(['status' => 'Success', 'messages' => "Berhasil $message !"]),200);
        }else{
            return response()->json(buildResponseGagal(['status' => 'Error', 'messages' => "Gagal $message!"]),200);
        }
    }
    function delete(Keluarga $keluarga){
        $cr = $this->keluargaRepository->delete($keluarga);
        if ($cr) {
            return response()->json(["status"=>true,"msg"=>"Berhasil, di Hapus!"]);
        } else {
            return response()->json(["status"=>false,"msg"=>"Gagal, di Hapus!"]);
        }
    }
}