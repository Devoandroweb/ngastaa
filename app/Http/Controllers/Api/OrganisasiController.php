<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pegawai\RiwayatOrganisasi;
use App\Repositories\Organisasi\OrganisasiRepository;
use Illuminate\Http\Request;

class OrganisasiController extends Controller
{
    private $organisasiRepository;
    function __construct(OrganisasiRepository $organisasiRepository) {
        $this->organisasiRepository = $organisasiRepository;
    }
    function list(){
        try{
            $data = $this->organisasiRepository->list();
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
        $cr = $this->organisasiRepository->store();
        $message = $this->organisasiRepository->getMessage();
        if ($cr) {
            return response()->json(["status"=>true,"msg"=>"Berhasil, $message!"]);
        } else {
            return response()->json(["status"=>false,"msg"=>"Gagal, $message!"]);
        }
    }
    function delete(RiwayatOrganisasi $riwayatOrganisasi){
        $cr = $this->organisasiRepository->delete($riwayatOrganisasi);
        if ($cr) {
            return response()->json(["status"=>true,"msg"=>"Berhasil, di Hapus!"]);
        } else {
            return response()->json(["status"=>false,"msg"=>"Gagal, di Hapus!"]);
        }
    }
}
