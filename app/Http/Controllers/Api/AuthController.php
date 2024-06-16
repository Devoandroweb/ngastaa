<?php

namespace App\Http\Controllers\Api;

use App\Constants\System;
use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\PegawaiResource;
use App\Mail\OTPEmail;
use App\Models\Pegawai\DataPresensi;
use App\Models\Pegawai\Imei;
use App\Models\User;
use App\Traits\Whatsapp;
use Illuminate\Http\Request;
use App\Models\Pegawai\RiwayatShift;
use App\Repositories\Password\PasswordRepository;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

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
            // if($this->passwordRepository->changePasswordMobile() == 1){
            //     return response()->json(buildResponseSukses(true),200);
            // }elseif($this->passwordRepository->changePasswordMobile() == 2){
            //     return response()->json(buildResponseGagal([
            //         'message'=>'Password lama tidak sesuai',
            //     ]),200);
            // }else{
            //     return response()->json(buildResponseGagal([
            //         'message'=>'Password lama dan baru tidak boleh sama',
            //     ]),200);
            // }
            if($this->passwordRepository->changePasswordMobile() == 1){
                return response()->json(buildResponseSukses([
                    'message'=>'Password Berhasil di ubah',
                    'status'=>1
                ]),200);
            }elseif($this->passwordRepository->changePasswordMobile() == 2){
                return response()->json(buildResponseGagal([
                    'message'=>'Password lama tidak sesuai',
                    'status'=>0
                ]),200);
            }else{
                return response()->json(buildResponseGagal([
                    'message'=>'Password lama dan baru tidak boleh sama',
                    'status'=>0
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
    function checkVerif(){
        $user = User::whereNoHp(request('nip'))->first('no_wa_verif');
        if($user->no_wa_verif){
            return response()->json(["status"=>true,"message"=>"Nomor Whatsapp ter-verifikasi"],200);
        }
        return response()->json(["status"=>false,"message"=>"Nomor Whatsapp belum ter-verifikasi"],200);
    }
    function sendOtp($type){

        $otp = mt_rand(100000, 999999);
        if($type=="whatsapp"){
            $noWaOriginal = request('no_wa');
            $noWa = convertToInternationalFormat($noWaOriginal);
            $notRegister = json_decode($this->verif($noWa))->status;
            if(!$notRegister){
                return response()->json(["status"=>false,"message"=>"Nomor Whatsapp tidak terdaftar"],200);
            }
            $user = User::whereIn("no_hp",[$noWa,$noWaOriginal])->first();
            if(!$user){
                return response()->json(["status"=>false,"message"=>"Pengguna/Karyawan tidak di temukan"],200);
            }
            $user->otp = $otp;
            $user->update();
            $this->sendMessage($noWa,"*HRM-BAPAS-69*\nHi! Ini adalah kode OTP Anda: *$otp*. Gunakan kode ini untuk verifikasi akun Anda. Jangan berikan kode ini kepada siapapun untuk menjaga keamanan akun Anda.");
            return response()->json(["status"=>true,"message"=>"OTP Whatsapp sukses terkirim"],200);
        }elseif($type=="email"){
            $email = request('email');
            $user = User::whereEmail($email)->first();

            if(!$user){
                return response()->json(["status"=>false,"message"=>"Email tidak di temukan"],200);
            }else{
                // if(!$user->email_verified_at){
                //     return response()->json(["status"=>true,"message"=>"Email belum ter-verifikasi"],200);
                // }
                try {
                    $user->otp = $otp;
                    $user->update();
                    Mail::to($user->email)->send(new OTPEmail($user->name,$otp));
                    File::append("email.log",now() ." | Otp Success Sending | $user->email | $otp");
                } catch (\Throwable $th) {
                    File::append("email.log",now() ." | Otp Failed Sending | ".$th->getMessage());
                }
            }
            return response()->json(["status"=>true,"message"=>"OTP Email sukses terkirim"],200);

        }else{
            return response()->json(["status"=>false,"message"=>"Not Url Prefix"],400);
        }
    }
    function saveOtp($type){

        if($type=="whatsapp"){
            $noWaOriginal = request('no_wa');
            $noWa = convertToInternationalFormat($noWaOriginal);
            $user = User::whereIn("no_hp",[$noWa,$noWaOriginal])->first('otp');
            $otp = request('otp');
            if(!$user){
                return response()->json(["status"=>false,"message"=>"Nomor Whatsapp salah, silahkan masukkan dengan benar."],200);
            }
            if($user->otp!=$otp){
                return response()->json(["status"=>false,"message"=>"Kode OTP tidak sesuai, silahkan masukkan dengan benar."],200);
            }
            $user->otp = null;
            $user->no_wa_verif = 1;
            $user->update();
        }elseif($type=="email"){
            $user = User::whereEmail(request('email'))->first();
            $otp = request('otp');
            // dd($user);
            if(!$user){
                return response()->json(["status"=>false,"message"=>"Email tidak di temukan, silahkan masukkan dengan benar."],200);
            }
            if($user->otp!=$otp){
                return response()->json(["status"=>false,"message"=>"Kode OTP tidak sesuai, silahkan masukkan dengan benar."],200);
            }
        }else{
            return response()->json(["status"=>false,"message"=>"Not Url Prefix"],400);
        }
        return response()->json(["status"=>true,"message"=>"OTP sukses ter-verifikasi"],200);
    }

    function changeNewPassword(){
        $user = User::whereOtp(request('otp'))->first();
        if($user){
            $newPassword = request('new-password');
            $user->password = Hash::make($newPassword);
            $user->otp = null;
            $user->update();
            return response()->json(["status"=>true,"message"=>"Password berhasil di ubah."],200);
        }
        return response()->json(["status"=>false,"message"=>"Otp Salah."],200);
    }

}
