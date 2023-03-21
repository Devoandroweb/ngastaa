<?php

namespace App\Repositories\Izin;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Izin;
use App\Models\Presensi\TotalIzin;

class IzinRepositoryImplement extends Eloquent implements IzinRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;
    protected $dataTotalIzin;
    protected $periode_bulan;
    public function __construct(TotalIzin $mdTotalIzin)
    {
        $this->dataTotalIzin = $mdTotalIzin->get();
        $this->periode_bulan = date("Y-m");
    }

    function calculateTotalIzin($nip){
        $result = 0;
        foreach ($this->dataTotalIzin as $totalIzin) {
            if($totalIzin->nip == $nip){
                $result += $totalIzin->total;
            }
        }
        return $result;
    }
}
