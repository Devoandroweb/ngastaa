<?php

namespace App\Http\Controllers;

use App\Models\PengajuanPermit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PengajuanPermitController extends Controller
{
    function approv(PengajuanPermit $pengajuanPermit){
        $pengajuanPermit->update(["status"=>1]);
        $dateNow = date("Y-m-d");
        Cache::get("presensi-datang-$dateNow");
        $user = $pengajuanPermit->user();
        $nip = $user->nip;
        $data = [
            'nip' => $nip,
            'periode_bulan' => date("Y-m"),
            'kordinat_datang' => $kordinat,
            'foto_datang' => $foto,
            'kode_tingkat' => $kode_tingkat,
            'kode_shift' => $kode_shift,
            'kode_jam_kerja' => $kode_jam_kerja,
            'tanggal_datang' => $tanggalIn,
            'lokasi_datang' => $location,
        ];

        $presensiDatang[$nip] = $data;
        Cache::forever("presensi-datang-$dateNow",$presensiDatang);

        return response()->json(["status"=>true,"message"=>"Berhasil melakukan Approv Pengajuan Exit Permit."],200);


    }
}
