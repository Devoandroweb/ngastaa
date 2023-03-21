<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Master\Shift;
use App\Models\Pegawai\DataPresensi;
use App\Models\Pegawai\RiwayatShift;
use App\Models\User;
use Illuminate\Http\Request;

class HomeUser extends Controller
{
    function index()
    {
        try {
            //code...
            $nip = request('nip');
           
            $user = User::role('pegawai')->with('jabatan_akhir')->first();
            $jabatan = array_key_exists('0', $user->jabatan_akhir->toArray()) ? $user->jabatan_akhir[0] : null;
            if( $jabatan == null){
                $jabatan = "-";
            }else{
                $jabatan = ((is_null($jabatan->tingkat?->nama)) ? "-" : $jabatan->tingkat?->nama);
            }
            $shift = RiwayatShift::with('shift')->where('is_akhir',1)->where('nip',$nip)->orderBy('created_at','desc')->first();
            $data = [
                'nama' => $user->getFullName(),
                'foto' => "public/{$user->image}",
                'jabatan' => $jabatan,
                'nama_shift' => (is_null($shift)) ? "-" : $shift->shift->nama,
                'jam_shift' => (is_null($shift)) ? "-" : date("H:i",strtotime($shift->shift->jam_tepat_datang))." - ".date("H:i",strtotime($shift->shift->jam_tepat_pulang)),
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
        // get shift
        
        // dd($shift);
    }
    function absen(){
        $nip = request('nip');
        $presensiHarian = DataPresensi::where('nip',$nip)->where('created_at',);
    }
}
