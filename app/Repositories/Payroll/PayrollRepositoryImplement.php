<?php

namespace App\Repositories\Payroll;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Payroll;
use App\Models\Payroll\GeneratePayroll;
use App\Models\Presensi\TotalPresensiDetail;

class PayrollRepositoryImplement extends Eloquent implements PayrollRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property GeneratePayroll|mixed $mGenereatePayroll;
    */
    protected $mGeneratePayroll;
    protected $mTotalPresensiDetail;
    protected $bulan; # Bulan
    protected $tahun; # Tahun
    public function __construct(
        GeneratePayroll $mGeneratePayroll,
        TotalPresensiDetail $mTotalPresensiDetail,
    )
    {
        $this->mGeneratePayroll = $mGeneratePayroll;
        $this->mTotalPresensiDetail = $mTotalPresensiDetail;
        $this->bulan = date("m"); # Bulan
        $this->tahun = date("Y"); # Tahun
    }
    function insertWithDivisi($kodePayroll){
        $kodeSkpd = auth()->user()->jabatan_akhir->first()?->kode_skpd;
        if($kodeSkpd){
            $this->mGeneratePayroll->create([
                'kode_payroll'=>$kodePayroll,
                'bulan'=> $this->bulan,
                'tahun'=> $this->tahun,
                'kode_skpd' => $kodeSkpd
            ]);
        }else{
            $this->mGeneratePayroll->create([
                'kode_payroll'=>$kodePayroll,
                'bulan'=> $this->bulan,
                'tahun'=> $this->tahun,
            ]);

        }
    }
    function calculatePresensi($nip = null) {

        # Bikin hari bulan lalu tgl 26 sampai end
        $year = date("Y");
        $currentMonth = date('m'); // Mendapatkan angka bulan saat ini (misalnya, 06 untuk bulan Juni)
        $previousMonth = date('m', strtotime('-1 month'));
        $daysInCurrentMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $year); // Menghitung total tanggal dalam bulan sebelumnya
        $daysInPreviousMonth = cal_days_in_month(CAL_GREGORIAN, $previousMonth, $year); // Menghitung total tanggal dalam bulan sebelumnya

        $rangedaysIncurrentMonth = range(1,26);
        $rangedaysInPreviousMonth = range(25,$daysInPreviousMonth);
        $totalDayCalculate = count($rangedaysIncurrentMonth)+count($rangedaysInPreviousMonth);

        $datePreviusMonth = [];
        $dateCurrentMonth = [];

        foreach ($rangedaysIncurrentMonth as $key => $day) {
            $dateCurrentMonth[] = "$year-$currentMonth-$day";
        }
        foreach ($rangedaysInPreviousMonth as $key => $day) {
            $datePreviusMonth[] = "$year-$previousMonth-$day";
        }

        $whereTanggal = array_merge($datePreviusMonth,$dateCurrentMonth);

        $rekapAbsensi = $this->mTotalPresensiDetail->where('nip',28)->whereIn('tanggal',$whereTanggal)->get();
        
    }
    // Write something awesome :)
}
