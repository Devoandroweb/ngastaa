<?php

namespace App\Repositories\Kursus;

use App\Http\Resources\Pegawai\RiwayatKursusResource;
use App\Http\Resources\Select\SelectResource;
use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Master\Kursus;
use App\Models\Pegawai\RiwayatKursus;
use App\Traits\Delete;
use App\Traits\MessageStore;

class KursusRepositoryImplement extends Eloquent implements KursusRepository{
    use MessageStore,Delete;
    protected $riwayatKursus;

    public function __construct(RiwayatKursus $riwayatKursus)
    {
        $this->riwayatKursus = $riwayatKursus;
    }
    function list(){
        $data = request()->user()->riwayat_kursus;
        return RiwayatKursusResource::collection($data);
    }
    function listMasterKursus(){
        $kursus = Kursus::orderBy('nama')->get();
        SelectResource::withoutWrapping();
        $kursus = SelectResource::collection($kursus);
        return $kursus;
    }
    public function store()
    {
        $nip = request()->user()->nip;
        $rules = [
            'kode_kursus' => 'required',
            'tempat' => 'required',
            'pelaksana' => 'required',
            'angkatan' => 'required',
            'tanggal_mulai' => 'nullable',
            'tanggal_selesai' => 'nullable',
            'jumlah_jp' => 'nullable',
            'no_sertifikat' => 'required',
            'tanggal_sertifikat' => 'nullable',
        ];

        if (request()->file('file')) {
            $rules['file'] = 'mimes:pdf|max:2048';
        }

        $data = request()->validate($rules);
        $data['tanggal_mulai'] = normalDateSystem(request("tanggal_mulai"));
        $data['tanggal_selesai'] =  normalDateSystem(request("tanggal_selesai"));
        $data['tanggal_sertifikat'] =  normalDateSystem(request("tanggal_sertifikat"));
        $id = request('id');

        if ($id) {
            if (request()->file('file')) {
                $file = $this->riwayatKursus->where('id', $id)->where('nip', $nip)->value('file');
                if ($file) {
                    @unlink($file);
                }
            }
        }

        // upload file
        if (request()->file('file')) {
            $file = $this->riwayatKursus->where('id', $id)->where('nip', $nip)->value('file');
            $dir = 'data_pegawai/'.$nip.'/kursus';
            if ($file) {
                @unlink($dir."/".$file);
            }
            $data['file'] = $dir.'/'.uploadFile($dir,request()->file('file'));
        }

        return $this->riwayatKursus->updateOrCreate(
            [
                'id' => $id,
                'nip' => $nip,
            ],
            $data
        );

    }
}
