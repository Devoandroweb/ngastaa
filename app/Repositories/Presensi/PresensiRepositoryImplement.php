<?php

namespace App\Repositories\Presensi;

use App\Models\Pegawai\DataPresensi;
use App\Models\Pegawai\DataVisit;
use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Presensi;

class PresensiRepositoryImplement extends Eloquent implements PresensiRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property DataPresensi|mixed $model;
    */
    protected $mDataPresensi;

    public function __construct(
        DataPresensi $mDataPresensi
    )
    {
        $this->mDataPresensi = $mDataPresensi;
    }
    function presensiDay($nip){
        $data = $this->mDataPresensi->where('nip', $nip)->whereDate('created_at', date('Y-m-d'))->first();
        $dataVisit = DataVisit::where('nip',$nip)->whereDate('created_at', date('Y-m-d'))->first();
        if($data != null){
            $data = [
                'nip' => $nip,
                'datang' => $data->tanggal_datang != null ? date("H:i:s",strtotime($data->tanggal_datang)) : "-",
                'istirahat' => $data->tanggal_istirahat != null ? date("H:i:s",strtotime($data->tanggal_istirahat)) : "-",
                'pulang' => $data->tanggal_pulang != null ? date("H:i:s",strtotime($data->tanggal_pulang)) : "-",
                'visit' => $dataVisit?->check_in != null ? date("H:i:s",strtotime($data->check_in)) : "-",
            ];
        }else{
            $data = [
                'nip' => $nip,
                'datang' => "-",
                'istirahat' => "-",
                'pulang' => "-",
                'visit' => "-",
            ];
        }
        return $data;
    }
    // Write something awesome :)
}
