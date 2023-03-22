<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\PegawaiResource;
use App\Http\Resources\Pegawai\RiwayatShiftResource;
use App\Http\Resources\Select\SelectResource;
use App\Models\Master\Shift;
use App\Models\Pegawai\RiwayatShift;
use App\Models\User;

class ShiftApiController extends Controller
{
    public function index()
    {
        $shift = Shift::orderBy('nama')->get();
        SelectResource::withoutWrapping();
        $shift = SelectResource::collection($shift);
        return response()->json(buildResponseSukses($shift),200);
    }

    public function store()
    {
        $nip = request('nip');
        $kode_shift = request('kode_shift');
        $keterangan = request('keterangan');

       if (request()->file('file')) {
            $file =  request()->file('file');
            $namaFile = uploadImage(public_path("reimbursement/$nip"),$file);
        }else{
            $namaFile = "";
        }

        $user = User::where('nip', $nip)->first();
        if($user){
                $data = [
                    'nip' => $nip,
                    'kode_shift' => $kode_shift,
                    'keterangan' => $keterangan,
                    'file' => "reimbursement/$nip/".$namaFile,
                ];

                $cek = RiwayatShift::where('nip', $nip)->where('status', 0)->count();
                if($cek > 0){
                    return response()->json(buildResponseSukses(['status' => FALSE, 'messages' => 'Anda telah melakukan pengajuan sebelumnya!']),200);
                }

                $cr = RiwayatShift::create($data);
                if($cr){
                    tambah_log($cr->nip, "App\Pegawai\RiwayatShift", $cr->id, 'diajukan');    
                    return response()->json(buildResponseSukses(['status' => TRUE,'messages' => 'Berhasil mengajukan Shift']),200);
                }else{
                    return response()->json(buildResponseSukses(['status' => FALSE,'messages' => 'Gagal mengajukan Shift']),200);
                }
        }else{
            return response()->json(buildResponseSukses(['status' => FALSE,'messages' => 'Pengguna tidak di temukan']),200);
        }
    }

    public function detail()
    {
        $id = request('id');
        if($id){
            $dpc = RiwayatShift::where('id', $id)->first();
            if($dpc){
                $user = User::where('nip', $dpc->nip)->first();
                if($user){
                    return response()->json(buildResponseSukses([
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
            $dpc = RiwayatShift::where('nip', $nip)->where('status', '!=', 99)->paginate(10);
            if($dpc){
                    return response()->json(buildResponseSukses([
                        'user' => PegawaiResource::make($user),
                        'data' => RiwayatShiftResource::collection($dpc),
                    ]),200);
            }else{
                return response()->json(buildResponseSukses(['status' => FALSE, 'messages' => 'Anda tidak memiliki pengajuan!' ]),200);
            }
        }else{
            return response()->json(buildResponseSukses(['status' => FALSE, 'messages' => 'User tidak ditemukan!']),200);
        }
    }
}
