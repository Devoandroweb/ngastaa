<?php

namespace App\Http\Controllers\Api;

use App\Constants\System;
use App\Http\Controllers\Controller;
use App\Models\Pegawai\DataPresensi;
use App\Models\User;
use App\Repositories\Pengumuman\PengumumanRepository;
use App\Repositories\Presensi\PresensiRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Cache;
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
            $user = request()->user();
            $data = Cache::remember("home-user-$user->nip",now()->addMinutes(System::CACHE_DURATION),function()use($user){
                $data['user'] = $this->userRepository->getUserWithIndentity($user);
                $data['presensi_today'] = $this->presensiRepository->presensiDay($data['user']['nip']);
                return $data;
            });
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
}
