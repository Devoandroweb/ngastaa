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
            $opd = false;
            $pegawai = User::where('nip',$nip)->first();

            if(!$pegawai){
                return response()->json(buildResponseSukses(['status'=>false,'messages'=>'NIP tidak di temukan']),200);
            }

            if(array_intersect(["opd","buk"],$pegawai->getRoleNames()->toArray())){
                $opd = true;
            }

            // dd($opd);
            $arrayNip = $this->pegawaiRepository->getAllPegawaiRoleOPD($opd)->pluck('nip')->toArray();
            // dd($arrayNip);
            $data = MAktifitas::whereIn('nip',$arrayNip)->with('pegawai')->orderBy('created_at','desc')->get();
            // dd($data);
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
}
