<?php

namespace App\Repositories\LokasiKerja;

use App\Models\MapLokasiKerja;
use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Master\Lokasi;

class LokasiKerjaRepositoryImplement extends Eloquent implements LokasiKerjaRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Lokasi|mixed $mLokasi;
    */
    protected $mLokasi;
    protected $mapLokasiKerja;

    public function __construct(
        Lokasi $mLokasi,
        MapLokasiKerja $mapLokasiKerja,
    )
    {
        $this->mLokasi = $mLokasi;
        $this->mapLokasiKerja = $mapLokasiKerja;
    }
    function saveManageLokasiKerja($kode_lokasi,$nips = []){
        $manageLokasiKerja = [];
        foreach ($nips as $nip) {
            array_push($manageLokasiKerja,['nip'=>$nip,'kode_lokasi']);
        }
        $this->mapLokasiKerja->insert($manageLokasiKerja);

    }
    function getPegawai($kode_lokasi){
        return $this->mapLokasiKerja->where('kode_lokasi',$kode_lokasi);
    }

    // Write something awesome :)
}
