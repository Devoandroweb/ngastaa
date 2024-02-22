<?php

namespace App\Repositories\Organisasi;

use App\Http\Resources\Pegawai\RiwayatOrganisasiResource;
use App\Models\Pegawai\RiwayatOrganisasi;
use App\Traits\Delete;
use App\Traits\MessageStore;
use LaravelEasyRepository\Implementations\Eloquent;


class OrganisasiRepositoryImplement extends Eloquent implements OrganisasiRepository{

    use MessageStore,Delete;
    protected $riwayatOrganisasi;

    public function __construct(RiwayatOrganisasi $riwayatOrganisasi)
    {
        $this->riwayatOrganisasi = $riwayatOrganisasi;
    }
    function list(){
        return RiwayatOrganisasiResource::collection(request()->user()->riwayat_organisasi);
    }
    public function store()
    {
        $nip = request()->user()->nip;
        $rules = [
            'nama_organisasi' => 'required',
            'jenis_organisasi' => 'required',
            'jabatan' => 'nullable',
            'tanggal_mulai' => 'nullable',
            'tanggal_selesai' => 'nullable',
            'nama_pimpinan' => 'nullable',
            'tempat' => 'nullable',
        ];

        if (request()->file('file')) {
            $rules['file'] = 'mimes:pdf|max:2048';
        }

        $data = request()->validate($rules);
        $data['tanggal_mulai'] = normalDateSystem(request("tanggal_mulai"));
        $data['tanggal_selesai'] =  normalDateSystem(request("tanggal_selesai"));

        $id = request('id');
        if ($id) {
            if (request()->file('file')) {
                $file = RiwayatOrganisasi::where('id', $id)->where('nip', $nip)->value('file');
                if ($file) {
                    @unlink($file);
                }
            }
        }

        // upload file
        if (request()->file('file')) {
            $file = RiwayatOrganisasi::where('id', $id)->where('nip', $nip)->value('file');
            $dir = 'data_pegawai/'.$nip.'/organisasi';
            if ($file) {
                @unlink($dir."/".$file);
            }$data['file'] = $dir.'/'.uploadFile($dir,request()->file('file'));
        }

        return RiwayatOrganisasi::updateOrCreate(
            [
                'id' => $id,
                'nip' => $nip,
            ],
            $data
        );
    }

    // Write something awesome :)
}
