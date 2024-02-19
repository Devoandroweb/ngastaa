<?php

namespace App\Repositories\Pendidikan;

use App\Models\Master\Pendidikan;
use App\Models\Pegawai\RiwayatPendidikan;
use LaravelEasyRepository\Implementations\Eloquent;

class PendidikanRepositoryImplement extends Eloquent implements PendidikanRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(Pendidikan $model)
    {
        $this->model = $model;
    }
    public function store()
    {
        $nip = auth()->user()->nip;
        $rules = [
            'kode_pendidikan' => 'required',
            'kode_jurusan' => 'nullable',
            'nomor_ijazah' => 'required',
            'nama_sekolah' => 'required',
            'tanggal_lulus' => 'required',
            'gelar_depan' => 'nullable',
            'gelar_belakang' => 'nullable',
            'is_akhir' => 'nullable',
        ];

        if (request()->file('file')) {
            $rules['file'] = 'mimes:pdf|max:2048';
        }

        $data = request()->validate($rules);
        $data['tanggal_lulus'] = normalDateSystem(request("tanggal_lulus"));

        if (request('is_akhir') == 1) {
            RiwayatPendidikan::where('nip', $nip)->update(['is_akhir' => 0]);
        }

        $id = request('id');
        if ($id) {
            if (request()->file('file')) {
                $file = RiwayatPendidikan::where('id', $id)->where('nip', $nip)->value('file');
                if ($file) {
                    @unlink($file);
                }
            }
        }

        //upload file
        if (request()->file('file')) {
            $file = RiwayatPendidikan::where('id', $id)->where('nip', $nip)->value('file');
            $dir = 'data_pegawai/'.$nip.'/pendidikan';
            if ($file) {
                @unlink($dir."/".$file);
            }
            $data['file'] = $dir.'/'.uploadFile($dir,request()->file('file'));
        }

        return RiwayatPendidikan::updateOrCreate(
            [
                'id' => $id,
                'nip' => $nip,
            ],
            $data
        );

        
    }

    // Write something awesome :)
}
