<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\PegawaiResource;
use App\Models\Pegawai\Imei;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Pegawai\RiwayatShift;

class AuthController extends Controller
{
    public function login(Request $request)
    {
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
                ], 422);
            }
        }
        $imei = $request->imei;

        $cek_imei = Imei::where('kode', $imei)->first();

        if($cek_imei){
            if($cek_imei->nip != $user->nip){
                return response()->json([
                    'status' => FALSE,
                    'message' => "Maaf, 1 Device hanya dapat digunakan untuk 1 Pegawai!",
                ], 422);
            }
        }else{
            Imei::create([
                'nip' => $user->nip,
                'kode' => $imei,
            ]);
        }
        $data = PegawaiResource::make($user);
        $riwayatShift = RiwayatShift::where("nip",$user->nip)->where("is_akhir",1)->orderByDesc('kode_shift')->get();

        if(count($riwayatShift) != 0){
            $data['shift'] = $riwayatShift[0]->kode_shift;
        }else{
            $data['shift'] = null;
        }

        $authToken = $user->createToken('auth-token')->plainTextToken;
        $role = ["visit" => true];
        $dataUser = $data;
        $dataRole = $role;

        $dataResponse = [
            "user"=>$dataUser,
            "role"=>$dataRole
        ];

        return response()->json([
             'status' => TRUE,
            'message' => "Auth Success !!",
            'data' => $dataResponse,
            'access_token' => $authToken,
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(buildResponseSukses(['status' => TRUE]),200);
    }

    public function getUser()
    {
        $nip = request('nip');
        $user = User::where('nip', $nip)->first();
        
        return response()->json(buildResponseSukses($user),200);
    }
}
