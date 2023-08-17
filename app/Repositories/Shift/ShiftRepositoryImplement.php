<?php

namespace App\Repositories\Shift;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Master\Shift;
use App\Models\MJadwalShift;

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
    function updatePenjadwalanShiftWithRangeDate($nip,$kodeShift,$forDate = ""){
        $forDate = explode(",",$forDate);
        if(count($forDate) > 1){
            $startDate = $forDate[0];
            $endDate = $forDate[1];
            $rangeDate = arrayTanggal($startDate,$endDate);
            foreach ($rangeDate as $date) {
                MJadwalShift::updateOrCreate([
                    'nip'=>$nip,
                    'kode_shift'=>$kodeShift,
                    'tanggal'=>$date
                ]);
            }
        }else{
            $startDate = $forDate[0];
        }

    }
}
