<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\PosisiResource;
use App\Http\Resources\Pegawai\RiwayatPendidikanResource;
use App\Models\Pegawai\RiwayatBahasa;
use App\Models\Pegawai\RiwayatPendidikan;
use App\Models\Pegawai\RiwayatPmk;
use Illuminate\Http\Request;
use App\Models\User as MUser;
class User extends Controller
{
    function index($nip){
            try{
            $user = MUser::role('pegawai')->where('nip', $nip)->with('jabatan_akhir','statusPegawai')->first();
            $dataJabatan = array_key_exists('0', $user->jabatan_akhir->toArray()) ? $user->jabatan_akhir[0] : null;
            $jabatan = "-";
            $divisi = "-";
            $status_pegawai = "-";
            $kode_tingkat = "-";
            if($dataJabatan != null){
                $jabatan = $dataJabatan->tingkat?->nama;
                $kode_tingkat = $dataJabatan->tingkat?->kode_tingkat;
                $divisi = $dataJabatan?->skpd?->nama;
            }
            if($user->statusPegawai != null){
                $status_pegawai = $user->statusPegawai->nama;
            }
            $data = [
                'nama' => $user->getFullName(),
                'foto' => $user->foto(),
                'jabatan' => $jabatan,
                'status_pegawai' => $status_pegawai,
                'kode_tingkat' => $kode_tingkat,
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
            // pegawai
            $user = MUser::where('nip', $nip)->first();

            // posisi
            PosisiResource::withoutWrapping();
            $posisi = PosisiResource::make($user);

            // pendidikan
            $Rpendidikan = RiwayatPendidikan::where('nip', $nip)
            ->orderByDesc('kode_pendidikan')
            ->get();
            // dd($Rpendidikan);
            $Rpendidikan = RiwayatPendidikanResource::collection($Rpendidikan);
            // bahasa
            $Rbahasa = RiwayatBahasa::where('nip', $nip)
            ->get();

            // pengalaman kerja
            $Rpmk = RiwayatPmk::where('nip', $nip)
            ->orderByDesc('tanggal_sk')
            ->get();

            unset($user->image);
            $data['pribadi'] = $user;
            $data['posisi'] = $posisi;
            $data['lokasi_kerja'] = $user->koordinat;
            $data['pendidikan'] = $Rpendidikan;
            $data['bahasa'] = $Rbahasa;
            $data['pengalaman_kerja'] = $Rpmk;

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
    function updateProfile(){
        try {
            $nip = request('nip');
            $name = request('name'); // nama colom
            $value = request('value'); // isi colom
            if($name == 'tanggal_lahir'){
                $value = date("Y-m-d",strtotime($value));
            }
            $user = MUser::where('nip', $nip)->first();
            $user->{$name} = $value;
            $user->update();
            return response()->json(buildResponseSukses([
                'message' => 'Update Profile Berhasil'
            ]),200);
        } catch (\Throwable $th) {
            return response()->json(buildResponseGagal([
                'message' => $th->getMessage()
            ]),500);

        }

    }
}
