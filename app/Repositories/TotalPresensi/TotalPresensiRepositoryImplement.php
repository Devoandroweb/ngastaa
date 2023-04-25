<?php

namespace App\Repositories\TotalPresensi;

use App\Models\AppStatusFunction;
use App\Models\Master\Shift;
use App\Models\Pegawai\DataPengajuanCuti;
use App\Models\Pegawai\DataPresensi;
use App\Models\Presensi\TotalIzinDetail;
use App\Models\Presensi\TotalIzin;
use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Presensi\TotalPresensi;
use App\Models\Presensi\TotalPresensiDetail;
use App\Repositories\Pegawai\PegawaiRepository;
use Illuminate\Support\Facades\Auth;

class TotalPresensiRepositoryImplement extends Eloquent implements TotalPresensiRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $pegawaiRepository;
    protected $mdTotalPresensi;
    protected $mdShifts;
    protected $mdPengajuanCuti;
    protected $mdTotalIzin;

    protected $allPegawai;
    protected $dataPresensi;
    protected $dataTotalPresensi;
    protected $dataTotalPresensiDetail;
    protected $dataTotalIzin;
    protected $allPengajuanCuti; // cuti / izin
    protected $nipMasuk;
    protected $totalPresensiDetail = [];
    protected $periodeBulan;
    public function __construct(
        PegawaiRepository $pegawaiRepository,

        TotalPresensi $mdTotalPresensi,
        Shift $mdShifts,
        DataPengajuanCuti $mdPengajuanCuti,
        TotalIzin $mdTotalIzin,
        TotalPresensiDetail $mdTotalPresensiDetail
    )
    {
        $this->pegawaiRepository = $pegawaiRepository;

        $this->mdTotalPresensi = $mdTotalPresensi;
        $this->mdShifts = $mdShifts;
        $this->mdPengajuanCuti = $mdPengajuanCuti;
        $this->mdTotalIzin = $mdTotalPresensi;

        $this->periodeBulan = date("Y-m");
        $this->dataPresensi =  DataPresensi::where("tanggal_datang","!=",null)->where("tanggal_pulang","!=",null)->get();
        // dd($this->dataPresensi);
        $this->dataTotalPresensi = $mdTotalPresensi->where('periode_bulan',$this->periodeBulan)->get(['nip','masuk','telat','alfa'])->toArray();
        $this->dataTotalPresensiDetail = $mdTotalPresensiDetail->get();
        $this->dataTotalIzin = $mdTotalIzin->where('periode_bulan',$this->periodeBulan)->get(['nip','kode_cuti','total','periode_bulan'])->toArray();
        $this->allPengajuanCuti = $mdPengajuanCuti->where('status',1)->get();
        $this->nipMasuk = [];
        
    }

    function calculatePresensi()
    {
        try {
            if($this->checkAppStatusCalculate()){
                return 0;
            }
            // dd($this->dataTotalIzin);
            $dataInsertTotalPresensiDetail = [];
            $dataInsertTotalIzinDetail = [];
            $this->allPegawai = $this->pegawaiRepository->getAllPegawai();
            // foreach ($this->allPegawai as $a) {
            //     TotalPresensi::create([
            //         'nip'=>$a->nip,
            //         'periode_bulan'=>$this->periodeBulan,
            //     ]);
            // }
            // dd($this->dataTotalPresensi);
            foreach ($this->allPegawai as $pegawai) {
                $indexTotalPegawai = $this->searchIndex($this->dataTotalPresensi,'nip',$pegawai->nip);
                // if($indexTotalPegawai == "" || $indexTotalPegawai == null){
                //     array_push($dataInsertTotalPresensiDetail,[
                //         'nip' => $pegawai->nip,
                //         'tanggal' => date("Y-m-d"),
                //         'status' => 0,
                //         'kode_cuti' => 0,
                //         'periode_bulan' => $this->periodeBulan,
                //     ]);
                // }
                $presensi = $this->existingPresensi($pegawai->nip);
                //cek pegawai di data_presensi
     
                if($presensi == null){
                    // cek pegawai di izin/cuti
                    // dd($pegawai);
                    $izin = $this->existingIzin($pegawai->nip);
                    if($izin != null){
                        // $this->dataTotalPresensi[$indexTotalPegawai]['izin']++;
                        $indexTotalIzin = $this->searchIndexIzin($this->dataTotalIzin,'nip','kode_cuti',$pegawai->nip,$izin->kode_cuti);
                        $this->dataTotalIzin[$indexTotalIzin]['total']++;
                        if(!$this->existingTotalDetail(date("Y-m-d"),4)){
                            array_push($dataInsertTotalPresensiDetail,[
                                'nip' => $pegawai->nip,
                                'tanggal' => date("Y-m-d"),
                                'status' => 4,
                                'kode_cuti' => $izin->kode_cuti,
                                'periode_bulan' => $this->periodeBulan,
                            ]);
                        }
                        array_push($dataInsertTotalIzinDetail,[
                            'nip' => $pegawai->nip,
                            'tanggal' => date("Y-m-d"),
                            'kode_cuti' => $izin->kode_cuti,
                            'periode_bulan' => $this->periodeBulan,
                        ]);
                        TotalIzin::where('nip',$pegawai->nip)->where('kode_cuti',$izin->kode_cuti)->update($this->dataTotalIzin[$indexTotalIzin]);
                        TotalIzinDetail::insert($dataInsertTotalIzinDetail);
                    }else{
                        
                        $this->dataTotalPresensi[$indexTotalPegawai]['alfa']++;
                        if(!$this->existingTotalDetail(date("Y-m-d"),3)){
                            array_push($dataInsertTotalPresensiDetail,[
                                'nip' => $pegawai->nip,
                                'tanggal' => date("Y-m-d"),
                                'status' => 3,
                                'kode_cuti' => null,
                                'periode_bulan' => $this->periodeBulan,
                            ]);
                        }
                    }
                }else{
                    // masuk
                    // cek telat
                    if($this->existingTelat($presensi->tanggal_datang,$presensi->kode_shift)){
                        $this->dataTotalPresensi[$indexTotalPegawai]['telat']++;
                        if(!$this->existingTotalDetail(date("Y-m-d"),2)){
                            array_push($dataInsertTotalPresensiDetail,[
                                'nip' => $pegawai->nip,
                                'tanggal' => date("Y-m-d"),
                                'status' => 2,
                                'kode_cuti' => null,
                                'periode_bulan' => $this->periodeBulan,
                            ]);
                        }
                    }else{
                        try {
                            //code...
                            $this->dataTotalPresensi[$indexTotalPegawai]['masuk']++;
                        } catch (\Throwable $th) {
                            dd($indexTotalPegawai);
                        }
                        if(!$this->existingTotalDetail(date("Y-m-d"),1)){
                            array_push($dataInsertTotalPresensiDetail,[
                                'nip' => $pegawai->nip,
                                'tanggal' => date("Y-m-d"),
                                'status' => 1,
                                'kode_cuti' => null,
                                'periode_bulan' => $this->periodeBulan,
                            ]);
                        }
                    }
                }
                TotalPresensi::where('nip',$pegawai->nip)->update($this->dataTotalPresensi[$indexTotalPegawai]);
                
            }
            // dd($dataInsertTotalPresensiDetail);
            TotalPresensiDetail::insert($dataInsertTotalPresensiDetail);

            # UPDATE APP STATUS FUNCTION
            AppStatusFunction::where('name','calculate_presensi')->update(['value' => 1]);
            return 1;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
        
    }
    
    function existingPresensi($nip){
        foreach ($this->dataPresensi as $presensi) {
            if($nip == $presensi->nip){
                return $presensi;
            }
        }
        return null;
    }
    function existingTelat($tanggal_datang, $kode_shift)
    {
        
        $shift = $this->searchShift($kode_shift);
        if($shift != null){
            $jam_tutup_datang = strtotime($shift->jam_tutup_datang);
            $jamTepatNToleransi = date("Y-m-d")." ".date("H:i:s", strtotime("+{$shift->toleransi_datang} minutes",$jam_tutup_datang));
            // dd($jamTepatNToleransi);
            if(date("Y-m-d H:i:s", strtotime($tanggal_datang)) >= date("Y-m-d H:i:s",strtotime($jamTepatNToleransi))){
                return true;
            }
        }
        return false;
    }
    function existingIzin($nip){
        
        $dateNow = date('Y-m-d');
        $pengajuanCuti = $this->getOnePengajuanCuti($nip);
        if($pengajuanCuti != null){
            if($dateNow >= date("Y-m-d",strtotime($pengajuanCuti->tanggal_mulai)) && $dateNow <= date("Y-m-d",strtotime($pengajuanCuti->tanggal_selesai))){
                return $pengajuanCuti;
            }
        }
        return null;
    }
    function existingTotalDetail($tanggal,$status)
    {
        foreach ($this->dataTotalPresensiDetail as $presensiDetail) {
            if($tanggal == $presensiDetail->tanggal && $status == $presensiDetail->status){
                return true;
            }
        }
        return false;
    }
    function getOnePengajuanCuti($nip){
        foreach ($this->allPengajuanCuti as $pengajuanCuti) {
            if($pengajuanCuti->nip == $nip){
                return $pengajuanCuti;
            }
        }
        return null;
    }
    
    function searchShift($kode_shift){
        $result = null;
        foreach ($this->mdShifts->all() as $shift) {
            if($kode_shift == $shift->kode_shift){
                $result = $shift;
            }
        }
        return $result;
    }
    function searchIndex($array,$key,$value){
        foreach($array as $index => $arr){
            if($arr[$key] === $value){
                return $index;
            }
        }
        // dd($array,$value);  
        return null;
    }
    function searchIndexIzin($array,$key1,$key2,$value1,$value2){
        foreach($array as $index => $arr){
            if($arr[$key1] == $value1 && $arr[$key2] == $value2){
                return $index;
            }
        }
        return null;
    }
    function checkAppStatusCalculate(){
        $value = AppStatusFunction::where('name','calculate_presensi')->first();
        if($value->value == 1){
            return true;
        }
        return false;
    }
}
