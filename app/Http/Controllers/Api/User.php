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
use App\Models\UserFace;

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
            if(file_exists(public_path($user->image))){
                $foto = url("public/{$user->image}");
            }else{
                $foto = asset("/dist/img/logo_lets_work_greyscale.png");
            }
            $data = [
                'nama' => $user->getFullName(),
                'foto' => $foto,
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
            if($name == 'image'){
                if(request()->hasFile('value')){
                    @unlink($user->first()->image);
                }
                $dir = "data_pegawai/".$nip."/foto";
                $image =  uploadImage($dir,request()->file('value'));
                $value = $dir.'/'.$image;
            }
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
    function changeAddress(){
        try {
            $nip = request('nip');
            $alamat = request('alamat');
            $alamat_ktp = request('alamat_ktp');
            $user = MUser::where('nip', $nip)->first();
            $user->alamat = $alamat;
            $user->alamat_ktp = $alamat_ktp;
            $user->update();
            return response()->json(buildResponseSukses([
                'message' => 'Update Alamat Berhasil'
            ]),200);
        } catch (\Throwable $th) {
            return response()->json(buildResponseGagal([
                'message' => $th->getMessage()
            ]),500);

        }
    }
    function registerFaceRecognition() {
        try {
            if(request()->hasFile('image')){
                $image = request()->file('image');
                $nip = request()->file('nip');
                $dir = "../data_pegawai/$nip";
                $dirFile = "$dir/".uploadImage(public_path($dir),$image);
                UserFace::firstOrCreate(['nip'=>$nip,'image_face'=>$dirFile]);
            }
            //code...
            return response()->json(buildResponseSukses([
                'message' => 'Sukses Daftar Face'
            ]),200);
        } catch (\Throwable $th) {
            return response()->json(buildResponseGagal([
                'message' => $th->getMessage()
            ]),500);

        }

    }
}
