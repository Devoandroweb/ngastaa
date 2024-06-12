<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PengajuanPermit;
use Illuminate\Http\Request;

class PengajuanPermitController extends Controller
{
    function store(){
        request()->validate([
            'ttd' => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);
        $data = request()->all();
        if(request()->has("ttd")){
            $ttd = request()->file('ttd');
            $content = file_get_contents($ttd->getRealPath());
            $data["nip"] = request()->user()->nip;
            $data["ttd"] = base64_encode($content);
            PengajuanPermit::create($data);
            return response()->json(["status"=>true,"message"=>"Berhasil melakukan Pengajuan Exit Permit."],200);
        }
    }
}
