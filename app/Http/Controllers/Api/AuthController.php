<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\PegawaiResource;
use App\Models\Pegawai\Imei;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Pegawai\RiwayatShift;
use App\Repositories\Password\PasswordRepository;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    private $passwordRepository;
    function __construct(PasswordRepository $passwordRepository)
    {
        $this->passwordRepository = $passwordRepository;
    }
    public function login(Request $request)
    {
        // return response()->json([
        //     'data' => $request->all()
        // ], 200);
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $credentials = request(['email', 'password']);
        $user = User::where('email', $request->email)->orWhere('nip', $request->email)->first();
        if (!auth()->attempt($credentials)) {
            if(!$user || !password_verify($request->password, $user->password)){
                return response()->json([
                    'status' => FALSE,
                    'message' => 'Nomor pegawai atau password tidak benar.',
                ], 200);
            }
        }
        // $imei = $request->imei;

        // $cek_imei = Imei::where('kode', $imei)->first();

        // if($cek_imei){
        //     if($cek_imei->nip != $user->nip){
        //         return response()->json([
        //             'status' => FALSE,
        //             'message' => "Maaf, 1 Device hanya dapat digunakan untuk 1 Pegawai!",
        //         ], 200);
        //     }
        // }else{
        //     Imei::create([
        //         'nip' => $user->nip,
        //         'kode' => $imei,
        //     ]);
        // }
        $user->status_password = $this->passwordCheck($user->nip);

        $data = PegawaiResource::make($user);
        // $data->(['status_password'=>)]);
        // dd($data);
        $riwayatShift = RiwayatShift::where("nip",$user->nip)->where("is_akhir",1)->orderByDesc('kode_shift')->get();
        // $data['status_password'] = $this->passwordCheck($data['nip']);
        if(count($riwayatShift) != 0){
            $data['shift'] = $riwayatShift[0]->kode_shift;
        }else{
            $data['shift'] = null;
        }

        // dd($data);
        $authToken = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'status' => TRUE,
            'message' => "Auth Success !!",
            'data' => $data,
            'access_token' => $authToken,
        ], 200);
    }
    function passwordCheck($nip){
        $user = User::where('nip',$nip)->first();
        if(!Hash::check($nip, $user->password)){
            return true;
        }else{
            return false;
        }
    }
    function changePassword(){
        try {
            if($this->passwordRepository->changePasswordMobile()){
                return response()->json(buildResponseSukses([
                    'message'=>'Password Berhasil di ubah',
                    'status'=>1
                ]),200);
            }else{
                return response()->json(buildResponseSukses([
                    'message'=>'Password lama tidak sesuai',
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
}
