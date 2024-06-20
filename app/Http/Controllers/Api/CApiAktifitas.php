<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AktifitasResource;
use App\Models\MAktifitas;
use App\Models\User;
use App\Repositories\Pegawai\PegawaiRepository;
use Illuminate\Http\Request;

class CApiAktifitas extends Controller
{
    protected $pegawaiRepository;
    protected $pegawaiWithRole;
    function __construct(
        PegawaiRepository $pegawaiRepository
    ){
        $this->pegawaiRepository = $pegawaiRepository;
    }
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
    function listOpd(){
        try {
            // dd(request()->all());
            $nip = request()->query('nip');
            $kodeSkpd = request()->query('kode_skpd');
            $user = User::where('nip',$nip)->first();
            if(!$user){
                return response()->json(buildResponseSukses(['status'=>false,'messages'=>'NIP tidak di temukan']),200);
            }
            $arrayNip = $this->pegawaiRepository->allPegawaiWithRole($kodeSkpd,true)->pluck('nip')->toArray();
            // dd($arrayNip);
            $data = MAktifitas::whereIn('nip',$arrayNip)->with('user')->orderBy('created_at','desc')->get();

            $data = AktifitasResource::collection($data);
            // $data->{"foto"} = url('public/'.$data->foto);
            return response()->json(buildResponseSukses($data),200);
        } catch (\Throwable $th) {
            return response()->json(buildResponseGagal($th->getMessage()),400);
        }
    }
    function store(){
        try {

            $nip = request('nip');
            $jamMulai = request('jam_mulai');
            $koordinat = request('koordinat');
            $keterangan = request('keterangan');
            // dd(MAktifitas::where('nip',$nip)->whereDate('created_at',date('Y-m-d'))->first());
            if(MAktifitas::where('nip',$nip)->whereDate('created_at',date('Y-m-d'))->first()){
                return response()->json(buildResponseSukses(['status' => 'Success', 'messages' => 'Maaf, anda sudah melakukan Aktifitas untuk hari ini!!']),200);
            }
            if (request()->file('foto')) {
                $file =  request()->file('foto');
                $path = "aktifitas/$nip";
                $foto = "$path/".uploadImage(public_path($path),$file);
            }else{
                $foto = "";
            }
            $data = [
                'nip' => $nip,
                'jam_mulai' => $jamMulai,
                'koordinat' => $koordinat,
                'keterangan' => $keterangan,
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
    function checkOut(){
        try{
            $idAktifitas = request('id_aktifitas');
            $dataAktifitas = MAktifitas::find($idAktifitas);
            $dataAktifitas->jam_selesai = date("Y-m-d H:i:s");
            $dataAktifitas->update();
            return response()->json(buildResponseSukses(['status' => 'Success', 'messages' =>'Sukses Checkout Aktifitas']),200);
        } catch (\Throwable $th) {
            return response()->json(buildResponseSukses($th->getMessage()),400);
        }
    }
}
