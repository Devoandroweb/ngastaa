<?php

namespace App\Repositories\JamKerja;

use App\Models\HariJamKerja;
use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\MJamKerja;
use Illuminate\Support\Facades\Cache;

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
    )
    {
        $this->mJamKerja = $mJamKerja;
        $this->hariJamKerja = collect(Cache::get('master-jam-kerja'));

    }
    function getJamKerjaWhere($where = []){
        return $this->mJamKerja->where($where);
    }
    function searchHariJamKerja($kodeJamKerja,$hari){
        $jk = (object) $this->hariJamKerja->where("kode_jam_kerja",$kodeJamKerja)->first();
        // dd($jk);
        if($jk){
            if($jk->tipe==1){
                return (object) $this->hariJamKerja->where('kode_jam_kerja',$kodeJamKerja)->where('hari',$jk->parent)->first();
            }else{
                return $jk;
            }
        }
        return null;
    }
}
