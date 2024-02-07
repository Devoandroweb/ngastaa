<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\PosisiResource;
use App\Models\Perusahaan;
use App\Models\User;

class DataPosisiControlller extends Controller
{
    public function index(User $pegawai)
    {
        PosisiResource::withoutWrapping();
        $pegawai = PosisiResource::make($pegawai);
        // return inertia('Pegawai/Posisi/index', compact('pegawai'));
        $perusahaan = Perusahaan::first();

        $jabatan = array_key_exists('0', $pegawai->jabatan_akhir->toArray()) ? $pegawai->jabatan_akhir[0] : null;

        if( $jabatan != null){
            $skpd = $jabatan?->skpd?->nama;
            $jenis_jabatan = $jabatan->jenis_jabatan ? jenis_jabatan($jabatan->jenis_jabatan) : "-";
            $tmt_jabatan = $jabatan->tanggal_tmt ? tanggal_indo($jabatan->tanggal_tmt) : "-";
            $masa_kerja = $jabatan->tanggal_sk ? get_masa_kerja($jabatan->tanggal_sk) : "-";
            $jabatan = $jabatan->tingkat?->nama ? $jabatan->tingkat?->nama : "-";
        }else{
            $skpd = "-";
            $jabatan = "-";
            $jenis_jabatan = "-";
            $tmt_jabatan = "-";
            $masa_kerja = "-";
        }

        $view = view('pages/pegawai/pegawai/datautama/posisi', compact('pegawai','perusahaan','skpd','jabatan','jenis_jabatan','tmt_jabatan','masa_kerja'));
        return response()->json(['view'=> $view->render()]);
    }
}
