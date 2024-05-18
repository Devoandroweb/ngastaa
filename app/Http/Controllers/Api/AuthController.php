<?php

namespace App\Http\Controllers\Api;

use App\Constants\System;
use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\PegawaiResource;
use App\Models\Pegawai\DataPresensi;
use App\Models\Pegawai\Imei;
use App\Models\User;
use App\Traits\Whatsapp;
use Illuminate\Http\Request;
use App\Models\Pegawai\RiwayatShift;
use App\Repositories\Password\PasswordRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use Whatsapp;
    private $passwordRepository;
    function __construct(PasswordRepository $passwordRepository)
    {
        $this->passwordRepository = $passwordRepository;
    }
    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $credentials = request(['email', 'password']);
        $user = User::where('email', $request->email)->orWhere('nip', $request->email)->first(['id','nip','password','email','name']);
        if (!auth()->attempt($credentials)) {
            if(!$user || !password_verify($request->password, $user->password)){
                return response()->json([
                    'status' => FALSE,
                    'message' => 'Nomor pegawai atau password tidak benar.',
                ], 200);
            }
        }
        $nip = $user->nip;
        $user->status_password = !Hash::check($nip, $user->password);

        $data = PegawaiResource::make($user);

        $authToken = $user->createToken('auth-token')->plainTextToken;
        Cache::forever("data-user-$nip",$data);
        return response()->json([
            'status' => TRUE,
            'message' => "Auth Success !!",
            'data' => $data,
            'access_token' => $authToken,
        ], 200);
    }

    public function passwordCheck($nip){

        $user = User::where('nip',$nip)->first();
        if(!Hash::check($nip, $user->password)){
            return response()->json(buildResponseSukses([
                'status_password'=>true
            ]),200);
        }else{
            return response()->json(buildResponseSukses([
                'status_password'=>false
            ]),200);
        }
    }
    function changePassword(){
        try {
            if($this->passwordRepository->changePasswordMobile() == 1){
                return response()->json(buildResponseSukses(true),200);
            }elseif($this->passwordRepository->changePasswordMobile() == 2){
                return response()->json(buildResponseGagal([
                    'message'=>'Password lama tidak sesuai',
                ]),200);
            }else{
                return response()->json(buildResponseGagal([
                    'message'=>'Password lama dan baru tidak boleh sama',
                ]),200);
            }
        } catch (\Throwable $th) {
            return response()->json(buildResponseGagal(['message'=>$th->getMessage()]),500);
        }
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        // $nip = request('nip');
        // Imei::where('nip',$nip)->first()->delete();
        return response()->json(buildResponseSukses(['status' => TRUE]),200);
    }

    public function getUser()
    {
        $nip = request('nip');
        $user = User::where('nip', $nip)->first();

        return response()->json(buildResponseSukses($user),200);
    }
    function checkWAVerif(){
        $user = request()->user();
        if($user->no_wa_verif){
            return response()->json(["status"=>true,"message"=>"Nomor Whatsapp ter-verifikasi"],200);
        }
        return response()->json(["status"=>false,"message"=>"Nomor Whatsapp belum ter-verifikasi"],200);
    }
    function sendWAOtp(){
        $noWa = request('no_wa');
        $notRegister = json_decode($this->verif($noWa))->not_registered;
        if($notRegister){
            return response()->json(["status"=>false,"message"=>"Nomor Whatsapp tidak terdaftar"],200);
        }
        $otp = mt_rand(100000, 999999);
        $user = request()->user();
        // dd($user);
        $noWa = convertToInternationalFormat($noWa);
        $user->no_hp = $noWa;
        $user->otp = $otp;
        $user->update();
        $this->sendMessage($noWa,"*HRM-BAPAS-69*\nHi! Ini adalah kode OTP Anda: *$otp*. Gunakan kode ini untuk verifikasi akun Anda. Jangan berikan kode ini kepada siapapun untuk menjaga keamanan akun Anda.");
        return response()->json(["status"=>true,"message"=>"OTP Whatsapp sukses terkirim"],200);
    }
    function saveOtp(){
        $user = request()->user();
        $otp = request('otp');
        if($user->otp!=$otp){
            return response()->json(["status"=>false,"message"=>"Kode OTP tidak sesuai, silahkan masukkan dengan benar."],200);
        }
        $user->otp = null;
        $user->no_wa_verif = 1;
        $user->update();
        return response()->json(["status"=>true,"message"=>"OTP sukses ter-verifikasi"],200);
    }
    function checkWaSimilar(){
        $user = request()->user();
        $noWa = request('no_wa');
        if($user->no_hp==convertToInternationalFormat($noWa)){
            return $this->sendWAOtp();
        }
        return response()->json(["status"=>false,"message"=>"Nomor Whatsapp tidak sesuai, silahkan masukkan dengan benar."],200);
    }
    function changeNewPassword(){
        $newPassword = request('new-password');
        $user = request()->user();
        $user->password = Hash::make($newPassword);
        $user->update();
        return response()->json(["status"=>true,"message"=>"Password berhasil di ubah."],200);
    }
}
