<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\RiwayatKursusResource;
use App\Repositories\Kursus\KursusRepository;
use Illuminate\Http\Request;

class KursusKontroller extends Controller
{
    protected $kursusRepository;
    function __construct(KursusRepository $kursusRepository){
        $this->kursusRepository = $kursusRepository;

    }
    function list(){
        // dd($this->kursusRepository->list());
        try{
            $data = $this->kursusRepository->list();

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
    function listMasterKursus(){
        try{
            $data = $this->kursusRepository->listMasterKursus();

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
        $cr = $this->kursusRepository->store();
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
