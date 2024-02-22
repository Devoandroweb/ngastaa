<?php

namespace App\Repositories\Pendidikan;

use App\Http\Resources\Master\JurusanResource;
use App\Http\Resources\Master\PendidikanResource;
use App\Http\Resources\Pegawai\RiwayatPendidikanResource;
use App\Models\Master\Jurusan;
use App\Models\Master\Pendidikan;
use App\Models\Pegawai\RiwayatPendidikan;
use App\Traits\Delete;
use App\Traits\MessageStore;
use LaravelEasyRepository\Implementations\Eloquent;

class PendidikanRepositoryImplement extends Eloquent implements PendidikanRepository{

    use MessageStore,Delete;

    protected $riwayatPendidikan;

    public function __construct(RiwayatPendidikan $riwayatPendidikan)
    {
        $this->riwayatPendidikan = $riwayatPendidikan;
    }
    function list(){
        $data = request()->user()->riwayat_pendidikan;
        return RiwayatPendidikanResource::collection($data);
    }
    function listTingkatPendidikan(){
        $data = Pendidikan::orderBy('kode_pendidikan','desc')->get();
        return PendidikanResource::collection($data);
    }
    function listJurusanPendidikan($kode_pendidikan){
        $data = Jurusan::where('kode_pendidikan',$kode_pendidikan)->orderBy('nama','asc')->get();
        return JurusanResource::collection($data);
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
            $this->riwayatPendidikan->where('nip', $nip)->update(['is_akhir' => 0]);
        }

        $id = request('id');
        if ($id) {
            if (request()->file('file')) {
                $file = $this->riwayatPendidikan->where('id', $id)->where('nip', $nip)->value('file');
                if ($file) {
                    @unlink($file);
                }
            }
        }

        //upload file
        if (request()->file('file')) {
            $file = $this->riwayatPendidikan->where('id', $id)->where('nip', $nip)->value('file');
            $dir = 'data_pegawai/'.$nip.'/pendidikan';
            if ($file) {
                @unlink($dir."/".$file);
            }
            $data['file'] = $dir.'/'.uploadFile($dir,request()->file('file'));
        }

        return $this->riwayatPendidikan->updateOrCreate(
            [
                'id' => $id,
                'nip' => $nip,
            ],
            $data
        );


    }

    // Write something awesome :)
}
