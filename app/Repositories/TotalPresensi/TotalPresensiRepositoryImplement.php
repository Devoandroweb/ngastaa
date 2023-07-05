<?php

namespace App\Repositories\TotalPresensi;

use App\Models\AppStatusFunction;
use App\Models\Master\Shift;
use App\Models\MJamKerja;
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
    protected $mdJamKerja;
    protected $mdPengajuanCuti;
    protected $mdTotalIzin;

    protected $allPegawai;
    protected $dataPresensi;
    protected $dataPresensi2;
    protected $dataTotalPresensi;
    protected $dataTotalPresensiDetail;
    protected $dataTotalIzin;
    protected $allPengajuanCuti; // cuti / izin
    protected $nipMasuk;
    protected $date;
    protected $dateNow;
    protected $totalPresensiDetail = [];
    protected $periodeBulan;
    public function __construct(
        PegawaiRepository $pegawaiRepository,

        TotalPresensi $mdTotalPresensi,
        Shift $mdShifts,
        MJamKerja $mdJamKerja,
        DataPengajuanCuti $mdPengajuanCuti,
        TotalIzin $mdTotalIzin,
        TotalPresensiDetail $mdTotalPresensiDetail
    )
    {
        $this->pegawaiRepository = $pegawaiRepository;

        $this->mdTotalPresensi = $mdTotalPresensi;
        $this->mdShifts = $mdShifts;
        $this->mdJamKerja = $mdJamKerja;
        $this->mdPengajuanCuti = $mdPengajuanCuti;
        $this->mdTotalIzin = $mdTotalPresensi;

        // $this->date = date("Y-m-d");
        // $this->dateNow = $this->date;
        $this->periodeBulan = date("Y-m");
        // $this->dataPresensi =  DataPresensi::where("tanggal_datang","!=",null)->whereDate('created_at', '=', $this->date)->where('hitung',0);
        // $this->dataPresensi2 =  DataPresensi::whereDate('created_at', '=', $this->date)->where('hitung',0);

        $this->dataTotalPresensi = $mdTotalPresensi->where('periode_bulan',$this->periodeBulan)->get(['nip','masuk','telat','alfa'])->toArray();

        $this->dataTotalPresensiDetail = $mdTotalPresensiDetail->get();
        $this->dataTotalIzin = $mdTotalIzin->where('periode_bulan',$this->periodeBulan)->get(['nip','kode_cuti','total','periode_bulan'])->toArray();
        $this->allPengajuanCuti = $mdPengajuanCuti->where('status',1)->get();
        $this->nipMasuk = [];

    }
    function manualCaculate()
    {
        # code...
        // $this->pegawaiRepository->updatoOrCreatoToTotalPresensi();
        // dd("done");
        // $tanggalBulan = ['2023-04-25','2023-04-26'];
        $tanggalBulan = arrayTanggal();
        // dd($tanggalBulan);
        foreach ($tanggalBulan as $value) {
            $this->date = $value;
            $this->dateNow = $value;
            // dd($value);
            $this->dataPresensi =  DataPresensi::where("tanggal_datang","!=",null)->whereDate('created_at', '=', $this->date)->where('hitung',0);
            $this->dataPresensi2 =  DataPresensi::whereDate('created_at', $this->date)->where('hitung',0);


            $this->calculatePresensi();
        }
    }
    function calculatePresensi()
    {
            if($this->checkAppStatusCalculate()){
                return 0;
            }
            $dataInsertTotalPresensiDetail = [];
            $dataInsertTotalIzinDetail = [];
            $this->allPegawai = $this->pegawaiRepository->getAllPegawai();
            foreach ($this->allPegawai as $pegawai) {
                $indexTotalPegawai = $this->searchIndex($this->dataTotalPresensi,'nip',$pegawai->nip);
                if($indexTotalPegawai == ""){
                    continue;
                }

                #Cek pegawai di data_presensi
                $presensi = $this->existingPresensi($pegawai->nip);
                $status = [];

                if($presensi == null){
                    if($this->checkHariLibur()){
                        continue;
                    }
                    $izin = $this->existingIzin($pegawai->nip);
                    if($izin != null){
                        #Izin
                        // $this->dataTotalPresensi[$indexTotalPegawai]['izin']++;
                        $indexTotalIzin = $this->searchIndexIzin($this->dataTotalIzin,'nip','kode_cuti',$pegawai->nip,$izin->kode_cuti);
                        $this->dataTotalIzin[$indexTotalIzin]['total']++;

                        if(!$this->existingTotalDetail($this->dateNow,4)){
                            array_push($status,"4");
                        }

                        array_push($dataInsertTotalIzinDetail,[
                            'nip' => $pegawai->nip,
                            'tanggal' => $this->dateNow,
                            'kode_cuti' => $izin->kode_cuti,
                            'periode_bulan' => $this->periodeBulan,
                        ]);
                        TotalIzin::where('nip',$pegawai->nip)->where('kode_cuti',$izin->kode_cuti)->update($this->dataTotalIzin[$indexTotalIzin]);
                        TotalIzinDetail::insert($dataInsertTotalIzinDetail);
                    }else{
                        #Alfa
                        $this->dataTotalPresensi[$indexTotalPegawai]['alfa']++;
                        if(!$this->existingTotalDetail($this->dateNow,3)){
                            array_push($status,"3");
                        }
                    }
                    array_push($dataInsertTotalPresensiDetail,[
                        'nip' => $pegawai->nip,
                        'tanggal' => $this->dateNow,
                        'status' => implode(",",$status),
                        'kode_cuti' => null,
                        'periode_bulan' => $this->periodeBulan,
                    ]);

                }else{
                    #Piket
                    if($this->checkHariLibur()){
                        array_push($status,"7");
                    }
                    $shift = $presensi->kode_shift ?? $presensi->kode_jam_kerja;
                    if($this->existingTelat($presensi->tanggal_datang,$shift)){
                        #Telat
                        $this->dataTotalPresensi[$indexTotalPegawai]['telat']++;
                        if(!$this->existingTotalDetail($this->dateNow,2)){
                            $status = ["2"];
                            if($this->existingPulangCepat($presensi->tanggal_pulang,$shift)){
                                array_push($status,"6");
                            }

                        }
                    }else{
                        if($presensi->tanggal_pulang == null){
                            #Tanpa Absen Pulang
                            array_push($status,"5");
                        }else{
                            if($this->existingPulangCepat($presensi->tanggal_pulang,$shift)){
                                #Pulang Cepat
                                array_push($status,"6");
                            }else{
                                #Masuk
                                array_push($status,"1");
                            }
                        }
                        $this->dataTotalPresensi[$indexTotalPegawai]['masuk']++;
                    }
                    if(!$this->existingTotalDetail($this->dateNow,1)){
                        array_push($dataInsertTotalPresensiDetail,[
                            'nip' => $pegawai->nip,
                            'tanggal' => $this->dateNow,
                            'status' => implode(",",$status),
                            'kode_cuti' => null,
                            'periode_bulan' => $this->periodeBulan,
                        ]);
                    }
                }
                // dd($this->dataTotalPresensi);
                TotalPresensi::where('nip',$pegawai->nip)->update($this->dataTotalPresensi[$indexTotalPegawai]);

            }
            // dd($dataInsertTotalPresensiDetail);
            TotalPresensiDetail::insert($dataInsertTotalPresensiDetail);

            # UPDATE APP STATUS FUNCTION
            // AppStatusFunction::where('name','calculate_presensi')->update(['value' => 1]);
            // $this->dataPresensi->update(['hitung',1]);
            return 1;


    }

    function existingPresensi($nip){
        // dd($this->dataPresensi2);
        foreach ($this->dataPresensi2->get() as $presensi) {
            if($nip == $presensi->nip){
                return $presensi;
            }
        }
        return null;
    }
    function existingTelat($tanggal_datang, $kode_shift)
    {
        $shift = $this->searchShift($kode_shift);

        // dd($shift);
        if($shift != null){

            $jam_tepat_datang = strtotime($shift->jam_tepat_datang);
            $jamTepatNToleransi = $this->date." ".date("H:i:s", strtotime("+{$shift->toleransi_datang} minutes",$jam_tepat_datang));
            // if($this->date == "2023-06-19"){
            //     dd($jamTepatNToleransi, $shift);

            // }
            if($this->date." ".date("H:i:s", strtotime($tanggal_datang)) >= $jamTepatNToleransi){
                return true;
            }
        }
        return false;
    }
    function existingPulangCepat($tanggal_pulang, $kode_shift)
    {

        $shift = $this->searchShift($kode_shift);

        if($shift != null){
            $jam_tutup_pulang = strtotime($shift->jam_tutup_pulang);
            $jamTepatNToleransi = $this->date." ".date("H:i:s", strtotime("+{$shift->toleransi_pulang} minutes",$jam_tutup_pulang));
            // dd($jamTepatNToleransi);
            if(date("Y-m-d H:i:s", strtotime($tanggal_pulang)) <= date("Y-m-d H:i:s",strtotime($jamTepatNToleransi))){
                return true;
            }
        }
        return false;
    }
    function existingIzin($nip){

        // $this->dateNow = date('Y-m-d');
        $pengajuanCuti = $this->getOnePengajuanCuti($nip);
        if($pengajuanCuti != null){
            if($this->dateNow >= date("Y-m-d",strtotime($pengajuanCuti->tanggal_mulai)) && $this->dateNow <= date("Y-m-d",strtotime($pengajuanCuti->tanggal_selesai))){
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
    function checkHariLibur(){
        $hariSabtuMinggu = cekHariAkhirPekan($this->date);
        $hariLibur = cekHariLibur($this->date);
        // dd($this->dataPresensi);
        if($hariSabtuMinggu){
            return true;
        }
        if($hariLibur){
            return true;
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

        // dd($this->mdJamKerja->all());
        # Jam Kerja
        // dd($kode_shift);
        foreach ($this->mdJamKerja->all() as $jamKerja) {
            if($kode_shift == $jamKerja->kode){
                // dd($kode_shift);
                return $jamKerja;
            }
        }

        # Jam Shift
        foreach ($this->mdShifts->all() as $shift) {
            if($kode_shift == $shift->kode_shift){
                return $shift;
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
