<?php

namespace App\Repositories\PengalamanKerja;

use App\Http\Resources\Pegawai\RiwayatPmkResource;
use App\Models\Pegawai\RiwayatPmk;
use App\Traits\MessageStore;
use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\PengalamanKerja;
use App\Traits\Delete;

class PengalamanKerjaRepositoryImplement extends Eloquent implements PengalamanKerjaRepository{

    use MessageStore,Delete;
    protected $riwayatPmk;

    public function __construct(RiwayatPmk $riwayatPmk)
    {
        $this->riwayatPmk = $riwayatPmk;
    }
    function list(){
        return RiwayatPmkResource::collection(request()->user()->riwayat_pmk);
    }
    public function store()
    {
        $nip = request()->user()->nip;
        $rules = [
            'jenis_pmk' => 'required',
            'instansi' => 'required',
            'tanggal_awal' => 'required',
            'tanggal_akhir' => 'required',
            // 'nomor_sk' => 'required',
            // 'tanggal_sk' => 'required',
            'masa_kerja_bulan' => 'required',
            'masa_kerja_tahun' => 'required',
            'nomor_bkn' => 'nullable',
            'tanggal_bkn' => 'nullable',
        ];

        if (request()->file('file')) {
            $rules['file'] = 'mimes:pdf|max:2048';
        }

        $data = request()->validate($rules);

        $data['tanggal_awal'] = normalDateSystem(request("tanggal_awal"));
        $data['tanggal_akhir'] = normalDateSystem(request("tanggal_akhir"));

        $id = request('id');
        if ($id) {
            if (request()->file('file')) {
                $file = RiwayatPmk::where('id', $id)->where('nip', $nip)->value('file');
                if ($file) {
                    @unlink($file);
                }
            }
        }

        // upload file
        if (request()->file('file')) {
            $file = RiwayatPmk::where('id', $id)->where('nip', $nip)->value('file');
            $dir = 'data_pegawai/'.$nip.'/pengalaman_kerja';
            if ($file) {
                @unlink($dir."/".$file);
            }
            $data['file'] = $dir.'/'.uploadFile($dir,request()->file('file'));
        }

        return RiwayatPmk::updateOrCreate(
            [
                'id' => $id,
                'nip' => $nip,
            ],
            $data
        );
    }
    // Write something awesome :)
}
