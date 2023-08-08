<?php

namespace App\Repositories\JamKerja;

use App\Models\HariJamKerja;
use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\MJamKerja;

class JamKerjaRepositoryImplement extends Eloquent implements JamKerjaRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property MJamKerja|mixed $jamKerja;
    */
    protected $mJamKerja;
    protected $hariJamKerja;

    public function __construct(
        MJamKerja $mJamKerja,
        HariJamKerja $hariJamKerja,
    )
    {
        $this->mJamKerja = $mJamKerja;
        $this->hariJamKerja = $hariJamKerja->get();
    }
    function getJamKerjaWhere($where = []){
        return $this->mJamKerja->where($where);
    }
    function searchHariJamKerja($kodeJamKerja,$hari){
        foreach ($this->hariJamKerja as $hariJamKerja) {
            if($hariJamKerja->kode_jam_kerja == $kodeJamKerja && $hariJamKerja->hari == $hari){
                if($hariJamKerja->tipe == 1){
                    $hariJamKerja = $this->searchHariJamKerja($kodeJamKerja,$hariJamKerja->parent);
                }
                return $hariJamKerja;
            }
        }
        return null;
    }
    // Write something awesome :)
}
