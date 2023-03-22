<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Pengajuan\LemburPengajuanResource;
use App\Http\Resources\Pegawai\PegawaiResource;
use App\Models\Pegawai\DataPengajuanLembur;
use App\Models\User;

class LemburApiController extends Controller
{
    public function store()
    {
        $nip = request('nip');
        $tanggal = request('tanggal') ?? date("Y-m-d");
        $jam_mulai = request('jam_mulai');
        $jam_selesai = request('jam_selesai');
        $keterangan = request('keterangan');

        if (request()->file('file')) {
            $file =  request()->file('file');
            $namaFile = uploadImage(public_path("lembur/$nip"),$file);
        }else{
            $namaFile = "";
        }

        $user = User::where('nip', $nip)->first();

        if($user){
            
            $data = [
                'nip' => $nip,
                'tanggal' => date("Y-m-d",strtotime($tanggal)),
                'jam_mulai' => $jam_mulai,
                'jam_selesai' => $jam_selesai,
                'keterangan' => $keterangan,
                'file' => "lembur/$nip/".$namaFile,
            ];
            $cek = DataPengajuanLembur::where('nip', $nip)->where('status', 0)->count();
            if($cek > 0){
                return response()->json(buildResponseSukses(['status' => FALSE, 'messages' => 'Anda telah melakukan pengajuan sebelumnya!']),200);
            }
            
            $cr = DataPengajuanLembur::create($data);
            if($cr){
                tambah_log($cr->nip, "App\Pegawai\DataPengajuanLembur", $cr->id, 'diajukan');    
                return response()->json(buildResponseSukses(['status' => TRUE]),200);
            }else{
                return response()->json(buildResponseGagal(['status' => FALSE, 'messages' => 'Server Erorr 405']),405);
            }

        }else{
            return response()->json(buildResponseSukses(['status' => FALSE, 'messages' => 'User tidak ditemukan!']),200);
        }
    }

    public function detail()
    {
        $id = request('id');
        if($id){
            $dpc = DataPengajuanLembur::where('id', $id)->first();
            if($dpc){
                $user = User::where('nip', $dpc->nip)->first();
                if($user){
                    return response()->json(buildResponseSukses([
                        'user' => PegawaiResource::make($user),
                        'data' => $dpc,
                    ]),200);
                }else{
                    return response()->json(buildResponseSukses(['status' => FALSE ]),200);
                }
            }else{
                return response()->json(buildResponseSukses(['status' => FALSE ]),200);
            }
        }else{
            return response()->json(buildResponseSukses(['status' => FALSE ]),200);
        }
    }

    public function lists()
    {
        $nip = request('nip');
        $user = User::where('nip', $nip)->first();
        if($user){
            $dpc = DataPengajuanLembur::where('nip', $nip)->get();
            if($dpc){
                    return response()->json(buildResponseSukses([
                        'user' => PegawaiResource::make($user),
                        'data' => LemburPengajuanResource::collection($dpc),
                    ]),200);
            }else{
                return response()->json(buildResponseSukses(['status' => FALSE, 'messages' => 'Anda tidak memiliki pengajuan!' ]),200);
            }
        }else{
            return response()->json(buildResponseSukses(['status' => FALSE, 'messages' => 'User tidak ditemukan!' ]),200);
        }
    }
}
