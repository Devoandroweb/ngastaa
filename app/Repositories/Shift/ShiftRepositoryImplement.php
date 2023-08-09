<?php

namespace App\Repositories\Shift;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Master\Shift;

class ShiftRepositoryImplement extends Eloquent implements ShiftRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Shift|mixed $mShift;
    */
    protected $mShift;

    public function __construct(Shift $mShift)
    {
        $this->mShift = $mShift;
    }
    function shiftWihSkpd($kode_skpd = null){
        $result = null;
        if($kode_skpd){
            $result = $this->mShift->where('kode_skpd',$kode_skpd);
        }else{
            $result = $this->mShift;
        }
        return $result->orderBy('nama');
    }
    // Write something awesome :)
}
