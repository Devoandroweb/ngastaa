<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Pengajuan\CutiPengajuanResource;
use App\Http\Resources\Pegawai\PegawaiResource;
use App\Http\Resources\Select\SelectResource;
use App\Models\Master\Cuti;
use App\Models\Pegawai\DataPengajuanCuti;
use App\Models\User;
use App\Repositories\Pegawai\PegawaiRepository;
use Illuminate\Http\Request;

class CutiApiController extends Controller
{
    protected $pegawaiRepository;
    protected $pegawaiWithRole;
    function __construct(
        PegawaiRepository $pegawaiRepository
    ){
        $this->pegawaiRepository = $pegawaiRepository;
    }
    public function index()
    {
        try{
            $cuti = Cuti::orderBy('nama')->get();
            SelectResource::withoutWrapping();
            $cuti = SelectResource::collection($cuti);
            return response()->json(buildResponseSukses($cuti),200);
        } catch (\Throwable $th) {
            return response()->json(buildResponseSukses($th->getMessage()),400);
        }
    }

    public function store()
    {
        $nip = request('nip');
        // return response()->json(buildResponseSukses(['status' => FALSE, 'messages' => $nip]),200);

        $keterangan = request('keterangan');
        $kode_cuti = request('kode_cuti');
        $tanggal_mulai = request('tanggal_mulai') ?? date("Y-m-d");
        $tanggal_selesai = request('tanggal_selesai') ?? date("Y-m-d");

        $user = User::where('nip', $nip)->first();
        if($user){
            if($user->maks_cuti == 0){
                return response()->json(buildResponseSukses(['status' => FALSE, 'messages' => 'Kuota Cuti sudah habis!']),200);
            }
            $cek = DataPengajuanCuti::where('nip', $nip)->where('status', 0)->count();
            if($cek > 0){
                return response()->json(buildResponseSukses(['status' => FALSE, 'messages' => 'Anda telah melakukan pengajuan sebelumnya!']),200);
            }
            if (request()->file('file')) {
                $file =  request()->file('file');
                $namaFile = uploadImage(public_path("perizinan/$nip"),$file);
            }else{
                $namaFile = "";
            }

            $data = [
                'nip' => $nip,
                'kode_cuti' => $kode_cuti,
                'tanggal_mulai' => date("Y-m-d",strtotime($tanggal_mulai)),
                'tanggal_selesai' => date("Y-m-d",strtotime($tanggal_selesai)),
                'keterangan' => $keterangan,
                'file' => "perizinan/$nip/".$namaFile,
            ];

            try {
                $cr = DataPengajuanCuti::create($data);
            } catch (\Exception $e) {
                return response()->json(buildResponseSukses(['status' => FALSE, 'messages' => $e->getMessage()]),200);

            }

            if($cr){
                tambah_log($cr->nip, "App\Pegawai\DataPengajuanCuti", $cr->id, 'diajukan');
                return response()->json(buildResponseSukses(['status' => TRUE, 'messages' => 'Berhasil di ajukan']),200);
            }else{
                return response()->json(buildResponseSukses(['status' => FALSE, 'messages' => 'Gagal di ajukan']),200);
            }
        }else{
            return response()->json(buildResponseSukses(['status' => FALSE, 'messages' => 'Pegawai tidak di temukan']),200);
        }
    }

    public function detail()
    {
        $id = request('id');
        if($id){
            $dpc = DataPengajuanCuti::where('id', $id)->first();
            if($dpc){
                $user = User::where('nip', $dpc->nip)->first();
                if($user){
                    return response()->json(buildResponseSukses([
                        'status' => TRUE,
                        'user' => PegawaiResource::make($user),
                        'data' => $dpc,
                    ]),200);
                }else{
                    return response()->json(buildResponseSukses(['status' => FALSE]),200);
                }
            }else{
                return response()->json(buildResponseSukses(['status' => FALSE]),200);
            }
        }else{
            return response()->json(buildResponseSukses(['status' => FALSE]),200);
        }
    }

    public function lists()
    {
        $nip = request('nip');
        $user = User::where('nip', $nip)->first();
        if($user){
            $dpc = DataPengajuanCuti::where('nip', $nip)->get();
            // dd($dpc);
            $data = CutiPengajuanResource::collection($dpc);
            if($dpc){
                    return response()->json(buildResponseSukses([
                        'user' => PegawaiResource::make($user),
                        'data' => $data,
                    ]),200);
            }else{
                return response()->json(buildResponseSukses(['status' => FALSE, 'messages' => 'Anda tidak memiliki pengajuan!' ]),200);
            }
        }else{
            return response()->json(buildResponseSukses(['status' => FALSE, 'messages' => 'User tidak ditemukan!' ]),200);
        }
    }
    public function listsOpd()
    {
        $nip = request()->query('nip');
        $kodeSkpd = request()->query('kode_skpd');
        $user = User::where('nip',$nip)->first();
        if(!$user){
            return response()->json(buildResponseSukses(['status'=>false,'messages'=>'NIP tidak di temukan']),200);
        }
            // dd($opd);
        $arrayNip = $this->pegawaiRepository->allPegawaiWithRole($kodeSkpd,true)->pluck('nip')->toArray();
        // dd($arrayNip);
        if($user){
            $dpc = DataPengajuanCuti::whereIn('nip', $arrayNip)->where('status',1)->get();
            // dd($dpc);
            $data = CutiPengajuanResource::collection($dpc);
            if($dpc){
                    return response()->json(buildResponseSukses([
                        'user' => PegawaiResource::make($user),
                        'data' => $data,
                    ]),200);
            }else{
                return response()->json(buildResponseSukses(['status' => FALSE, 'messages' => 'Anda tidak memiliki pengajuan!' ]),200);
            }
        }else{
            return response()->json(buildResponseSukses(['status' => FALSE, 'messages' => 'User tidak ditemukan!' ]),200);
        }
    }


}
