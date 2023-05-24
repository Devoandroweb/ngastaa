<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\DataVisitResource;
use App\Models\Master\Visit;
use App\Models\Pegawai\DataVisit;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class VisitApiController extends Controller
{
    public function store()
    {
        $nip = request('nip');
        $kordinat = request('kordinat');
        $kode_visit = request('kode_visit');

        #$newOrOld = request('new_old'); # 1 : new | 2 : old
        $newOrOld = request('new_old'); # 1 : new | 2 : old

        $timeZone = request('timezone') ?? 'WITA';

        if ($timeZone == 'WIB') {
            $tanggalIn = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s')) - (60 * 60));
        } elseif ($timeZone == 'WIT') {
            $tanggalIn = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s')) + (60 * 60));
        } else {
            $tanggalIn = date('Y-m-d H:i:s');
        }

        $user = User::where('nip', $nip)->first();
        if (!$user) {
            return response()->json(buildResponseSukses(['status' => 'Error', 'messages' => 'User tidak ditemukan!']),200);
        }

        $cek = DataVisit::where('nip', $nip)->where('kode_visit', $kode_visit)->whereDate("tanggal", date("Y-m-d"))->count();

        if ($cek > 0) {
            return response()->json(buildResponseSukses(['status' => 'Error', 'messages' => 'Anda Telah melakukan Visit Ke Lokasi Ini!']),200);
        } else {
            if (request()->file('image')) {
                $file =  request()->file('image');
                $foto = uploadImage(public_path("visit/$nip"),$file);
            }else{
                $foto = "";
            }
            $cr = false;
            if($newOrOld == 2){
                $data = [
                    'nip' => $nip,
                    'kode_visit' => $kode_visit,
                    'kordinat' => $kordinat,
                    'foto' => $foto,
                    'tanggal' => $tanggalIn
                ];
            }else{
                # tambah visit baru
                $namaVisit = request('nama_visit');
                $alamat = request('alamat');
                $kode_visit = (string) Str::uuid();
                $qrName = (string) Str::uuid().".svg";
                QrCode::generate($kode_visit, public_path("visit_qr\\".$qrName));
                Visit::create([
                    'kode_visit' => $kode_visit,
                    'nama' => $namaVisit,
                    'alamat' => $alamat,
                    'qr' => $qrName
                ]);

                $data = [
                    'nip' => $nip,
                    'kode_visit' => $kode_visit,
                    'kordinat' => $kordinat,
                    'foto' => $foto,
                    'tanggal' => $tanggalIn
                ];
            }
            $cr = DataVisit::create($data);
            if ($cr) {
                return response()->json(buildResponseSukses(['status' => 'Success', 'messages' => 'Berhasil Melakukan Absensi Kunjungan!', 'keterangan' => 'pagi']),200);
            } else {
                return response()->json(buildResponseGagal(['status' => 'Error', 'messages' => 'Terjadi Kesalahan!']),400);
            }
        }

    }
    function checkOut(){
        try{
            $idDataVisit = request('id_data_visit');
            $dataVisit = DataVisit::find($idDataVisit);
            $dataVisit->check_out = date("Y-m-d H:i:s");
            $dataVisit->update();
            return response()->json(buildResponseSukses(['status' => 'Success', 'messages' =>'Sukses Checkout Visit']),200);
        } catch (\Throwable $th) {
            return response()->json(buildResponseSukses($th->getMessage()),400);
        }
    }
    public function index()
    {
        try {
            // dd(request()->all());
            $nip = request()->query('nip');
            if(!is_null(request()->query('mulai')) && !is_null(request()->query('selesai'))){

                $date = request()->query('mulai') ? date('Y-m-d', strtotime(request()->query('mulai'))) : date('Y-m-d', strtotime('-1 days'));
                $end =  request()->query('selesai') ? date('Y-m-d', strtotime(request()->query('selesai')) + (60 * 60 * 24)) : date('Y-m-d', strtotime('+1 days'));
                // dd($end);
                $data = DataVisit::where('nip', $nip)->whereBetween('tanggal', [$date, $end])->get();
            }else{
                $data = DataVisit::where('nip', $nip)->get();
            }

            // dd($data);
            $data = DataVisitResource::collection($data);

            return response()->json(buildResponseSukses($data),200);
        } catch (\Throwable $th) {
            return response()->json(buildResponseSukses($th->getMessage()),400);
        }

    }

    public function lokasi()
    {
        try{
            $kode = request('kode');

            $data = Visit::where('kode_visit', $kode)->first();
            if($data){
                $exp = explode(',', $data->kordinat);
                $data->latitude = (string) trim($exp[0]);
                $data->longitude = (string) trim($exp[1]);
                return response()->json(buildResponseSukses($data),200);
            }
            return response()->json(buildResponseSukses(null),200);
        } catch (\Throwable $th) {
            return response()->json(buildResponseSukses($th->getMessage()),400);
        }
    }
    function list_lokasi_visit(){
        try{

            $data = Visit::all();
            return response()->json(buildResponseSukses($data),200);
        } catch (\Throwable $th) {
            return response()->json(buildResponseSukses($th->getMessage()),400);
        }
    }
}
