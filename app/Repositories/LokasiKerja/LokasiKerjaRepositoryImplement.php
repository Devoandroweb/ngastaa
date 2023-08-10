<?php

namespace App\Repositories\LokasiKerja;

use App\Models\MapLokasiKerja;
use Illuminate\Support\Facades\DB;
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
        DB::transaction(function()use($kode_lokasi,$nips){
            // $this->mapLokasiKerja->where('kode_lokasi',$kode_lokasi)->delete();
            $manageLokasiKerja = [];
            foreach ($nips as $nip) {
                // array_push($manageLokasiKerja,['nip'=>$nip,'kode_lokasi'=>$kode_lokasi]);
                $this->mapLokasiKerja->updateOrCreate(['nip'=>$nip,'kode_lokasi'=>$kode_lokasi],['nip'=>$nip,'kode_lokasi'=>$kode_lokasi]);
            }
        });
        DB::commit();

    }
    function getPegawai($kode_lokasi){
        return $this->mapLokasiKerja->where('kode_lokasi',$kode_lokasi);
    }

    // Write something awesome :)
}
