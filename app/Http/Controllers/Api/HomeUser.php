<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Master\Shift;
use App\Models\Pegawai\DataPresensi;
use App\Models\Pegawai\RiwayatJamKerja;
use App\Models\Pegawai\RiwayatShift;
use App\Models\User;
use Illuminate\Http\Request;

class HomeUser extends Controller
{
    function index()
    {
        $nip = request('nip');

        $user = User::role('pegawai')->where('nip', $nip)->with('jabatan_akhir','jamKerja')->has('jabatan_akhir')->first();

        try {
            //code...
            $kode_tingkat = "-";
            $jabatan = array_key_exists('0', $user->jabatan_akhir->toArray()) ? $user->jabatan_akhir[0] : null;

            if( $jabatan == null){
                $jabatan = "-";
            }else{
                $kode_tingkat = $jabatan->tingkat?->kode_tingkat;

                $jabatan = ((is_null($jabatan->tingkat?->nama)) ? "-" : $jabatan->tingkat?->nama);
            }
            $RjamKerja = RiwayatJamKerja::with('jamKerja')->where('is_akhir',1)->where('nip',$nip)->orderBy('created_at','desc')->first();
            $shift = RiwayatShift::with('shift')->where('is_akhir',1)->where('nip',$nip)->orderBy('created_at','desc')->first();

            $namaShift = "-";
            $jamShift = "-";

            if($RjamKerja != null){
                if($RjamKerja->jamKerja != null){
                    $namaShift = (is_null($RjamKerja)) ? "-" : $RjamKerja->jamKerja?->nama;
                    $jamShift = (is_null($RjamKerja)) ? "-" : date("H:i",strtotime($RjamKerja->jamKerja?->jam_tepat_datang))." - ".date("H:i",strtotime($RjamKerja->jamKerja?->jam_tepat_pulang));
                }
            }elseif($shift != null){
                if($shift->shift != null){
                    $namaShift = (is_null($shift)) ? "-" : $shift->shift?->nama;
                    $jamShift = (is_null($shift)) ? "-" : date("H:i",strtotime($shift->shift?->jam_tepat_datang))." - ".date("H:i",strtotime($shift->shift?->jam_tepat_pulang));
                }

            }

            $data = [
                'nama' => $user->getFullName(),
                'foto' => "public/{$user->image}",
                'jabatan' => $jabatan,
                'kode_tingkat' => $kode_tingkat,
                'nama_shift' => $namaShift,
                'jam_shift' => $jamShift,
                'waktu_server' => hari(date('N')).", ".tanggal_indo(date("Y-m-d"))
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
