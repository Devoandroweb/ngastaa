<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\PegawaiResource;
use App\Http\Resources\Pegawai\PosisiResource;
use App\Http\Resources\Pegawai\RiwayatPendidikanResource;
use App\Models\Pegawai\RiwayatBahasa;
use App\Models\Pegawai\RiwayatPendidikan;
use App\Models\Pegawai\RiwayatPmk;
use Illuminate\Http\Request;
use App\Models\User as MUser;
use App\Models\UserFace;
use Illuminate\Support\Facades\Cache;

class User extends Controller
{
    function index($nip){
            try{
                // Cache::forget("data-user-001000");
                $data = Cache::get("data-user-$nip",function(){
                    $user = request()->user();
                    $jabatan = $user->jabatan_akhir->first();

                    // dd($jabatan);
                    $tingkat = $jabatan?->tingkat;
                    $nama_jabatan =  $tingkat?->nama;
                    $kode_eselon =  $user->getEselon();
                    $skpd = $jabatan?->skpd?->nama;

                    $user->kode_eselon = $kode_eselon;
                    $user->divisi = $skpd;
                    $user->nama_jabatan = $nama_jabatan;
                    return $user;
                });
                unset($data->jabatan_akhir);

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
            $user = request()->user();
            $nip = $user->nip;
            $name = request('name'); // nama colom
            $value = request('value'); // isi colom
            if($name == 'tanggal_lahir'){
                $value = date("Y-m-d",strtotime($value));
            }

            if($user){
                if($name == 'image'){
                    if(request()->hasFile('value')){
                        $imageDir = $user->image;
                        @unlink($imageDir);
                    }
                    // dd(request()->file('value'));
                    $dir = "data_pegawai/".$nip."/foto";
                    $image =  uploadImage($dir,request()->file('value'));
                    $value = $dir.'/'.$image;
                }
                $user->update([$name => $value]);
                Cache::forever("data-user-$nip",$user);
                return response()->json(buildResponseSukses([
                    'message' => 'Update Profile Berhasil',
                    'data' => $value
                ]),200);
            }else{
                return response()->json(buildResponseSukses([
                    'message' => 'User tidak di temukan',
                    'data' => $value
                ]),200);
            }



        } catch (\Throwable $th) {
            return response()->json(buildResponseGagal([
                'message' => $th->getMessage(),
                'data' => null,
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
                $dir = "../data_pegawai/$nip/face";
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
    function checkFaceRecognition() {
        try {
            $nip = request('nip');
            $face = UserFace::where(['nip'=>$nip,'face_image','!=',null]);
            if($face){
                return response()->json(buildResponseSukses([
                    'status' => false,
                    'message' => 'Face sudah tersedia'
                ]),200);
            }
            return response()->json(buildResponseSukses([
                'status' => true,
                'message' => 'Face belum tersedia'
            ]),200);
        } catch (\Throwable $th) {
            return response()->json(buildResponseGagal([
                'status' => false,
                'message' => $th->getMessage()
            ]),500);
        }
    }
}
