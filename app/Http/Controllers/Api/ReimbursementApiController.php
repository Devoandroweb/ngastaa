<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Pengajuan\ReimbursementPengajuanResource;
use App\Http\Resources\Pegawai\PegawaiResource;
use App\Http\Resources\Select\SelectResource;
use App\Models\Master\Reimbursement;
use App\Models\Pegawai\DataPengajuanReimbursement;
use App\Models\User;

class ReimbursementApiController extends Controller
{
    public function index()
    {
        $reimbursement = Reimbursement::orderBy('nama')->get();
        SelectResource::withoutWrapping();
        $reimbursement = SelectResource::collection($reimbursement);
        return response()->json(buildResponseSukses($reimbursement),200);
    }

    public function store()
    {
        $nip = request('nip');
        $kode_reimbursement = request('kode_reimbursement');
        $nilai = request('nilai');
        $keterangan = request('keterangan');



        $user = User::where('nip', $nip)->first();
        if($user){

                $cek = DataPengajuanReimbursement::where('nip', $nip)->where('status', 0)->count();
                if($cek > 0){
                    return response()->json(buildResponseSukses(['status' => FALSE, 'messages' => 'Anda telah melakukan pengajuan sebelumnya!']),200);
                }

                if (request()->file('file')) {
                    $file =  request()->file('file');
                    $namaFile = uploadImage(public_path("reimbursement/$nip"),$file);
                }else{
                    $namaFile = "";
                }

                $data = [
                    'nip' => $nip,
                    'kode_reimbursement' => $kode_reimbursement,
                    'nilai' => str_replace(",","",$nilai),
                    'keterangan' => $keterangan,
                    'file' => "reimbursement/$nip/".$namaFile,
                ];

                // if (request()->file('file')) {
                //     $data['file'] = request()->file('file')->storeAs($nip, $nip . "-reimbursement-" . request('nomor_surat') . ".pdf");
                // }
                $cr = DataPengajuanReimbursement::create($data);
                if($cr){
                    tambah_log($cr->nip, "App\Pegawai\DataPengajuanReimbursement", $cr->id, 'diajukan');
                    return response()->json(buildResponseSukses(['status' => TRUE, 'messages' => 'Sukses mengajukan Reimbursement!']),200);
                }else{
                    return response()->json(buildResponseSukses(['status' => FALSE, 'messages' => 'Gagal mengajukan Reimbursement!']),200);
                }
        }else{
            return response()->json(buildResponseSukses(['status' => FALSE, 'messages' => 'User tidak di temukan!']),200);
        }
    }

    public function detail()
    {
        $id = request('id');
        if($id){
            $dpc = DataPengajuanReimbursement::where('id', $id)->first();
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
            $dpc = DataPengajuanReimbursement::where('nip', $nip)->orderBy('created_at','desc')->paginate(10);
            if($dpc){
                    return response()->json(buildResponseSukses([
                        'user' => PegawaiResource::make($user),
                        'data' => ReimbursementPengajuanResource::collection($dpc),
                    ]),200);
            }else{
                return response()->json(buildResponseSukses(['status' => FALSE, 'messages' => 'Anda tidak memiliki pengajuan!' ]),200);
            }
        }else{
            return response()->json(buildResponseSukses(['status' => FALSE, 'messages' => 'User tidak ditemukan!' ]),200);
        }
    }
}
