<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pegawai\DataPresensi;
use App\Models\User;
use App\Repositories\Pengumuman\PengumumanRepository;
use App\Repositories\Presensi\PresensiRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Hash;

class HomeUser extends Controller
{
    protected $userRepository;
    protected $presensiRepository;
    protected $pengumumanRepository;
    function __construct(
        UserRepository $userRepository,
        PresensiRepository $presensiRepository,
        PengumumanRepository $pengumumanRepository,
    ){
        $this->userRepository = $userRepository;
        $this->presensiRepository = $presensiRepository;
        $this->pengumumanRepository = $pengumumanRepository;

    }
    function index()
    {
        try {
            $nip = request('nip');
            $data['user'] = $this->userRepository->getUserWithIndentity($nip);
            $data['presensi_today'] = $this->presensiRepository->presensiDay($nip);
            // $data['pengumuman'] =  $this->pengumumanRepository->getPengumuman();
            $data['user']['status_password'] = $this->passwordCheck($nip);
            return response()->json([
                'status' => TRUE,
                'message' => "Success",
                'data' => $data
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => FALSE,
                'message' => "Failed",
                'data' => $th->getMessage()." | ".$th->getFile()." | ".$th->getLine()
            ], 404);
        }
        // get shift

        // dd($shift);
    }
    function absen(){
        $nip = request('nip');
        $presensiHarian = DataPresensi::where('nip',$nip)->where('created_at',);
    }
    function passwordCheck($nip){
        $user = User::where('nip',$nip)->first();
        if(!Hash::check($nip, $user->password)){
            return true;
        }else{
            return false;
        }
    }
}
