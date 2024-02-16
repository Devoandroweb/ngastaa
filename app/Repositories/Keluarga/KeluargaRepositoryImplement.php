<?php

namespace App\Repositories\Keluarga;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Pegawai\Keluarga as PegawaiKeluarga;
use App\Models\User;

class KeluargaRepositoryImplement extends Eloquent implements KeluargaRepository{
    protected $pegawaiKeluarga;
    public function __construct(PegawaiKeluarga $pegawaiKeluarga)
    {
        $this->pegawaiKeluarga = $pegawaiKeluarga;
    }
    function semuaKeluargaList($nip) {
        return $this->getList($nip);
    }
    function orangTuaList($nip) {
        return $this->getList($nip,['ayah','ibu']);
    }
    function anakList($nip) {
        return $this->getList($nip,['anak']);
    }
    function pasanganList($nip) {
        return $this->getList($nip,['suami', 'istri']);
    }
    public function store(User $pegawai)
    {
        $rules = [
            'status' => 'required',
            'nama' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            // 'status_kehidupan' => 'required',
            'nip_keluarga' => 'nullable',
            'status_pernikahan' => 'nullable',
            'id_ibu' => 'nullable',
            'status_anak' => 'nullable',
            'anak_ke' => 'nullable',
            'jenis_kelamin' => 'nullable',
            'alamat' => 'nullable',
            'nomor_telepon' => 'nullable',
            'nomor_ktp' => 'nullable',
            'nomor_bpjs' => 'nullable',
            'nomor_akta_kelahiran' => 'nullable',
        ];
        if (request()->file('file_ktp')) {
            $rules['file_ktp'] = 'mimes:pdf|max:2048';
        }

        if (request()->file('file_bpjs')) {
            $rules['file_bpjs'] = 'mimes:pdf|max:2048';
        }
        if (request()->file('file_akta_kelahiran')) {
            $rules['file_akta_kelahiran'] = 'mimes:pdf|max:2048';
        }
        # ambil extension
        # cek ext, PDF

        $data = request()->validate($rules);

        $data['tanggal_lahir'] = normalDateSystem(request('tanggal_lahir'));

        if (request('is_akhir') == 1) {
            $this->pegawaiKeluarga->where('nip', $pegawai->nip)->update(['is_akhir' => 0]);
        }

        $id = request('id');
        if ($id) {
            if (request()->file('file_ktp')) {
                $file = $this->pegawaiKeluarga->where('id', $id)->where('nip', $pegawai->nip)->value('file_ktp');
                if ($file) {
                    @unlink($file);
                }
            }
            if (request()->file('file_bpjs')) {
                $file = $this->pegawaiKeluarga->where('id', $id)->where('nip', $pegawai->nip)->value('file_bpjs');
                if ($file) {
                    @unlink($file);
                }
            }
            if (request()->file('file_akta_kelahiran')) {
                $file = $this->pegawaiKeluarga->where('id', $id)->where('nip', $pegawai->nip)->value('file_akta_kelahiran');
                if ($file) {
                    @unlink($file);
                }
            }
        }

        // upload file
        if (request()->file('file_ktp')) {
            $file = $this->pegawaiKeluarga->where('id', $id)->where('nip', $pegawai->nip)->value('file_ktp');
            $dir = 'data_pegawai/'.$pegawai->nip.'/keluarga/ktp';
            if ($file) {
                @unlink($dir."/".$file);
            }
            $data['file_ktp'] = $dir.'/'.uploadFile($dir,request()->file('file_ktp'));
        }

        if (request()->file('file_bpjs')) {
            $file = $this->pegawaiKeluarga->where('id', $id)->where('nip', $pegawai->nip)->value('file_bpjs');
            $dir = 'data_pegawai/'.$pegawai->nip.'/keluarga/bpjs';
            if ($file) {
                @unlink($dir."/".$file);
            }
            $data['file_bpjs'] = $dir.'/'.uploadFile($dir,request()->file('file_bpjs'));
        }

        if (request()->file('file_akta_kelahiran')) {
            $file = $this->pegawaiKeluarga->where('id', $id)->where('nip', $pegawai->nip)->value('file_akta_kelahiran');
            // $data['file_akta_kelahiran'] = request()->file('file_akta_kelahiran')->storeAs($pegawai->nip, $pegawai->nip . "-akta-" . request('status') . ".pdf");
            $dir = 'data_pegawai/'.$pegawai->nip.'/keluarga/akta';
            if ($file) {
                @unlink($dir."/".$file);
            }
            $data['file_akta_kelahiran'] = $dir.'/'.uploadFile($dir,request()->file('file_akta_kelahiran'));
        }
        // dd($data);
        return $this->pegawaiKeluarga->updateOrCreate(
            [
                'id' => $id,
                'nip' => $pegawai->nip,
            ],
            $data
        );
    }
    function getList($nip,array $status = null){
        if($status){
            return $this->pegawaiKeluarga->where("nip",$nip)->whereIn('status',$status)->get();
        }
        return $this->pegawaiKeluarga->where("nip",$nip)->get();
    }
}
