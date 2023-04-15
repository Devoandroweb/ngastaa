<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AktifitasResource;
use App\Models\MAktifitas;
use Illuminate\Http\Request;

class CApiAktifitas extends Controller
{
    function index(){
        try {
            // dd(request()->all());
            $nip = request()->query('nip');
            $data = MAktifitas::where('nip',$nip)->orderBy('created_at','desc')->get();
            $data = AktifitasResource::collection($data);
            // $data->{"foto"} = url('public/'.$data->foto);
            return response()->json(buildResponseSukses($data),200);
        } catch (\Throwable $th) {
            return response()->json(buildResponseSukses($th->getMessage()),400);
        }
    }
    function store(){
        try {
            $nip = request('nip');
            $nama = request('nama');
            $koordinat = request('koordinat');
            if (request()->file('foto')) {
                $file =  request()->file('foto');
                $path = "aktifitas/$nip";
                $foto = "$path/".uploadImage(public_path($path),$file);
            }else{
                $foto = "";
            }
            $data = [
                'nip' => $nip,
                'nama' => $nama,
                'koordinat' => $koordinat,
                'foto' => $foto,
            ];
            $cr = MAktifitas::create($data);
            if ($cr) {
                return response()->json(buildResponseSukses(['status' => 'Success', 'messages' => 'Berhasil Menambahkan Aktifitas!', 'keterangan' => 'pagi']),200);
            }
            return response()->json(buildResponseGagal(['status' => 'Error', 'messages' => 'Gagal Menambahkan Aktifitas!']),200);
        } catch (\Throwable $th) {
            return response()->json(buildResponseGagal(['status' => 'Error', 'messages' => $th->getMessage()]),400);
            //throw $th;
        }
        
    }
}
