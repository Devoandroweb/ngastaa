<?php

namespace App\Repositories\Izin;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Izin;
use App\Models\Presensi\TotalIzin;
use App\Models\Presensi\TotalIzinDetail;

class IzinRepositoryImplement extends Eloquent implements IzinRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;
    protected $dataTotalIzin;
    protected $periodeBulan;
    public function __construct(TotalIzinDetail $mdTotalIzinDetail)
    {
        $this->dataTotalIzin = $mdTotalIzinDetail->get();
        $this->periodeBulan = date("Y-m");
    }

    function calculateTotalIzin($nip,$periodeBulan){
        $result = 0;
        foreach ($this->dataTotalIzin as $totalIzin) {
            if($totalIzin->nip == $nip && $totalIzin->periode_bulan == $periodeBulan){
                $result++;
            }
        }
        return $result;
    }
    function saveToTotalIzinDetail($izin) {
        $tanggalStart = $izin->tanggal_mulai;
        $tanggalEnd = $izin->tanggal_selesai;

        $tanggal = arrayTanggal($tanggalStart,$tanggalEnd);
        // dd(count($tanggal) > 12);
        if(count($tanggal) > 12){
            return false;
        }
        $dataSave = [];
        foreach ($tanggal as $tgl) {
            $dataSave[] = [
                'nip' => $izin->nip,
                'kode_cuti' => $izin->kode_cuti,
                'tanggal' => $tgl,
                'periode_bulan' => date("Y-m",strtotime($tgl)),
            ];
        }
        TotalIzinDetail::insert($dataSave);
        return true;
    }
}
