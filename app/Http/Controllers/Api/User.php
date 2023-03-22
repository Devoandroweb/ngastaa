<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User as MUser;
class User extends Controller
{
    function index(){
            try{
            $user = MUser::role('pegawai')->with('jabatan_akhir','statusPegawai')->first();
            $dataJabatan = array_key_exists('0', $user->jabatan_akhir->toArray()) ? $user->jabatan_akhir[0] : null;
            $jabatan = "-";
            $divisi = "-";
            $status_pegawai = "-";
            if($dataJabatan != null){
                $jabatan = $dataJabatan->tingkat?->nama;
                $divisi = $dataJabatan?->skpd?->nama;
            }
            if($user->statusPegawai != null){
                $status_pegawai = $user->statusPegawai->nama;
            }
            $data = [
                'nama' => $user->getFullName(),
                'foto' => "/public/{$user->image}",
                'jabatan' => $jabatan,
                'status_pegawai' => $status_pegawai,
                'divisi' => $divisi,
            ];
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
    public function detail($nip)
    {
        try{
            $user = MUser::where('nip', $nip)->first();
            unset($data->user);
            
            $data['data_pribadi'] = $user;
            $data['data_pribadi'] = $user;

            // dd($data);
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
}
