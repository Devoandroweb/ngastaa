<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pegawai\DataPresensi;
use App\Models\PengajuanPermit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PengajuanPermitController extends Controller
{
    function store(){
        request()->validate([
            'ttd' => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);
        $data = request()->all();
        $date = $data["tanggal"];
        $user = request()->user();
        if(PengajuanPermit::whereDate("tanggal",$date)->whereNip($user->nip)->first()){
            $date = date("d-m-Y",strtotime($date));
            return response()->json(["status"=>false,"message"=>"Anda sudah melakukan Pengajuan Exit Permit dengan tanggal $date."],200);
        }
        try {
            //code...
            DB::transaction(function()use($user,$data,$date){
                if(request()->has("ttd")){
                    $ttd = request()->file('ttd');
                    $content = file_get_contents($ttd->getRealPath());
                    $data["nip"] = $user->nip;
                    $data["ttd"] = base64_encode($content);
                    PengajuanPermit::create($data);
                    $presensiDatang = Cache::get("presensi-datang-$date");
                    if(!$presensiDatang[$user->nip]){
                        $kode_jam_kerja = null;
                        $kode_shift = null;
                        $jadwalShiftUser = $user->jadwalShift->where('tanggal',date('Y-m-d',strtotime($date)))->first();
                        if ($jadwalShiftUser) {
                            $kode_shift = $jadwalShiftUser->kode_shift;
                        } else {
                            $kode_jam_kerja = $user->jamKerja->where('is_akhir', 1)->first()?->kode_jam_kerja;
                            if (!$kode_jam_kerja) {
                                $kode_shift = $user->riwayat_shift->where('is_akhir', 1)->first()?->kode_shift;
                            }
                        }
                        $lokasiKerja = $user->lokasiKerja?->lokasiKerja;
                        $dataAbsen = [
                            'nip' => $user->nip,
                            'periode_bulan' => date("Y-m"),
                            'kordinat_datang' => $lokasiKerja->kordinat,
                            'kode_shift' => $kode_shift,
                            'kode_jam_kerja' => $kode_jam_kerja,
                            'tanggal_datang' => $date." ".$data["jam_kembali"],
                            'lokasi_datang' => $lokasiKerja->nama,
                        ];
                        $presensiDatang[$user->nip] = $dataAbsen;
                        Cache::forever("presensi-datang-$date",$presensiDatang);
                        DataPresensi::create($dataAbsen);
                        clearUserHome($user->nip);
                    }
                }
            });
            DB::commit();
            return response()->json(["status"=>true,"message"=>"Berhasil melakukan Pengajuan Exit Permit."],200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(["status"=>false,"message"=>"Gagal melakukan Pengajuan Exit Permit.".$th->getMessage()],200);

            //throw $th;
        }
    }
}
