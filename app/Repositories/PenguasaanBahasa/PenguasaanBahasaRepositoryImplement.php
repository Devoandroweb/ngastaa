<?php

namespace App\Repositories\PenguasaanBahasa;

use App\Http\Resources\Pegawai\RiwayatBahasaResource;
use App\Models\Pegawai\RiwayatBahasa;
use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\PenguasaanBahasa;
use App\Traits\Delete;
use App\Traits\MessageStore;

class PenguasaanBahasaRepositoryImplement extends Eloquent implements PenguasaanBahasaRepository{

    use MessageStore,Delete;
    protected $riwayatBahasa;

    public function __construct(RiwayatBahasa $riwayatBahasa)
    {
        $this->riwayatBahasa = $riwayatBahasa;
    }
    function list(){
        return RiwayatBahasaResource::collection(request()->user()->riwayat_bahasa);
    }
    public function store()
    {
        $nip = request()->user()->nip;
        $rules = [
            'nama_bahasa' => 'required',
            'penguasaan' => 'required',
            'jenis' => 'required',
        ];

        if (request()->file('file')) {
            $rules['file'] = 'mimes:pdf|max:2048';
        }

        $data = request()->validate($rules);

        $id = request('id');
        $dir = 'data_pegawai/'.$nip.'/bahasa';
        if ($id) {
            if (request()->file('file')) {
                $file = RiwayatBahasa::where('id', $id)->where('nip', $nip)->value('file');
                if ($file) {
                    @unlink($dir."/".$file);
                }
            }
        }

        // upload file
        if (request()->file('file')) {
            // $data['file'] = request()->file('file')->storeAs($nip, $nip . "-bahasa-" . request('no_sertifikat') . ".pdf");
            $data['file'] = $dir.'/'.uploadFile($dir,request()->file('file'));
        }

        return RiwayatBahasa::updateOrCreate(
            [
                'id' => $id,
                'nip' => $nip,
            ],
            $data
        );
    }
}
