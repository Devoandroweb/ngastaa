<?php

namespace App\Http\Controllers\Api\Keluarga;

use App\Http\Controllers\Controller;
use App\Http\Resources\KeluargaResource;
use App\Models\User;
use App\Repositories\Keluarga\KeluargaRepository;
use Illuminate\Http\Request;

class SemuaKeluargaController extends Controller
{
    private $keluargaRepository;
    function __construct(KeluargaRepository $keluargaRepository) {
        $this->keluargaRepository = $keluargaRepository;
    }
    function list(){
        try {
            $nip = request('nip');
            $status = request('status');
            switch ($status) {
                case 'orang-tua':
                    $data = $this->keluargaRepository->orangTuaList($nip);
                    break;
                case 'pasangan':
                    $data = $this->keluargaRepository->pasanganList($nip);
                    break;
                case 'anak':
                    $data = $this->keluargaRepository->anakList($nip);
                    break;
                default:
                    $data = $this->keluargaRepository->semuaKeluargaList($nip);
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
    function store(User $pegawai){
        $cr = $this->keluargaRepository->store($pegawai);
        if ($cr) {
            return response()->json(buildResponseSukses(['status' => 'Success', 'messages' => 'Berhasil Melakukan Absensi Kunjungan!', 'keterangan' => 'pagi']),200);
        } else {
            return response()->json(buildResponseGagal(['status' => 'Error', 'messages' => 'Terjadi Kesalahan!']),200);
        }
    }
}
