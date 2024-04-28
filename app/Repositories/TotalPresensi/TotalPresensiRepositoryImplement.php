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
    protected $mDataPresensi;
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
    protected $maxDate;
    protected $totalPresensiDetail = [];
    protected $periodeBulan;
    protected $tanggalDatang = null;
    public function __construct(
        PegawaiRepository $pegawaiRepository,

        DataPresensi $mDataPresensi,
        TotalPresensi $mdTotalPresensi,
        Shift $mdShifts,
        MJamKerja $mdJamKerja,
        DataPengajuanCuti $mdPengajuanCuti,
        TotalIzin $mdTotalIzin,
        TotalPresensiDetail $mdTotalPresensiDetail
    )
    {
        $this->pegawaiRepository = $pegawaiRepository;

        $this->mDataPresensi = $mDataPresensi;
        $this->mdTotalPresensi = $mdTotalPresensi;
        $this->mdShifts = $mdShifts->all();
        $this->mdJamKerja = $mdJamKerja->all();
        $this->mdPengajuanCuti = $mdPengajuanCuti;
        $this->mdTotalIzin = $mdTotalPresensi;

        // $this->date = date("Y-m-d");
        // $this->dateNow = $this->date;
        // $this->periodeBulan = "2023-06";
        // $this->dataPresensi =  DataPresensi::where("tanggal_datang","!=",null)->whereDate('created_at', '=', $this->date)->where('hitung',0);
        // $this->dataPresensi2 =  DataPresensi::whereDate('created_at', '=', $this->date)->where('hitung',0);

        $this->dataTotalPresensi = $mdTotalPresensi->where('periode_bulan',$this->periodeBulan)->get(['nip','masuk','telat','alfa'])->toArray();
        // dd($this->getLastMonthNow());
        $this->dataTotalPresensiDetail = $mdTotalPresensiDetail
                ->whereBetween("tanggal",[$this->getLastMonthNow()]);



        $this->dataTotalIzin = $mdTotalIzin->where('periode_bulan',$this->periodeBulan)->get(['nip','kode_cuti','total','periode_bulan'])->toArray();
        $this->allPengajuanCuti = $mdPengajuanCuti->where('status',1)->get();
        $this->nipMasuk = [];



    }
    public function manualCaculate()
    {
        // dd($this->dataTotalPresensiDetail->get()->count());
        if($this->dataTotalPresensiDetail->get()->count() != 0){
            $this->maxDate = $this->dataTotalPresensiDetail->max('tanggal');
            $this->maxDate = date("Y-m-d",strtotime($this->maxDate."+1 days"));
            // dd($this->maxDate);
        }else{
            $minDate = $this->mDataPresensi->where('periode_bulan','!=',null)->where('periode_bulan','!=',"")->get()->min('periode_bulan');
            // dd($minDate);
            if($minDate != null){
                $this->maxDate = $minDate."-01";
            }else{
                return 0; # Data Absen Kosong
            }
        }
        # $this->pegawaiRepository->updatoOrCreatoToTotalPresensi();
        // $dateStart = $this->maxDate;
        // $dateEnd = date("Y-m-d",strtotime("-1 days"));
        $dateStart = "2024-04-26";
        $dateEnd = "2024-04-27";
        // dd($dateStart,$dateEnd);
        # Check apakah tanggal nya sama, jika sama jangan hitung
        if($dateStart == $dateEnd){
            return 2; # Tanggal Masih Sama
        }
        // dd($dateStart,$dateEnd);
        # hitung
        $tanggalBulan = arrayTanggal($dateStart,$dateEnd);
        $this->allPegawai = $this->pegawaiRepository->getAllPegawai();
        $dataInsert = collect([]);
        // dd($tanggalBulan);
        foreach ($tanggalBulan as $date) {
            // dd($tanggalBulan);
            $this->date = $date;
            $this->dateNow = $date;
            $this->periodeBulan = date("Y-m",strtotime($date));

            // dd($value);
            $this->dataPresensi =  DataPresensi::where("tanggal_datang","!=",null)->whereDate('created_at', '=', $this->date)->where('hitung',0);
            $this->dataPresensi2 =  DataPresensi::whereDate('created_at', $this->date)->where('hitung',0);
            // echo $this->date;
            // dd($this->dataPresensi2->get());
            $dataInsert = collect($dataInsert)->concat($this->calculatePresensi());
        }
        // dd($dataInsert);
        TotalPresensiDetail::insert($dataInsert->toArray());

        return 1;
    }
    function calculatePresensi()
    {
        // dd($this->checkAppStatusCalculate());
            // if($this->checkAppStatusCalculate()){
            //     return 0;
            // }
            $dataInsertTotalPresensiDetail = [];
            $dataInsertTotalIzinDetail = [];

            // dd($this->allPegawai);
            foreach ($this->allPegawai as $pegawai) {
                // $indexTotalPegawai = $this->searchIndex($this->dataTotalPresensi,'nip',$pegawai->nip);
                // // dd($indexTotalPegawai);
                // if($indexTotalPegawai == ""){
                //     continue;
                // }

                #Cek pegawai di data_presensi
                $presensi = $this->existingPresensi($pegawai->nip);
                // dd($presensi);
                $status = [];
                // if($presensi!=null){
                //     dd($presensi,$pegawai->nip);
                // }
                if($presensi == null){
                    if($this->checkHariLibur()){
                        continue;
                    }
                    $izin = $this->existingIzin($pegawai->nip);
                    if($izin != null){
                        #Izin
                        // $this->dataTotalPresensi[$indexTotalPegawai]['izin']++;
                        // $indexTotalIzin = $this->searchIndexIzin($this->dataTotalIzin,'nip','kode_cuti',$pegawai->nip,$izin->kode_cuti);
                        // $this->dataTotalIzin[$indexTotalIzin]['total']++;

                        if(!$this->existingTotalDetail($this->dateNow,4)){
                            array_push($status,"4");
                        }

                        array_push($dataInsertTotalIzinDetail,[
                            'nip' => $pegawai->nip,
                            'tanggal' => $this->dateNow,
                            'kode_cuti' => $izin->kode_cuti,
                            'periode_bulan' => $this->periodeBulan,
                        ]);
                        // TotalIzin::where('nip',$pegawai->nip)->where('kode_cuti',$izin->kode_cuti)->update($this->dataTotalIzin[$indexTotalIzin]);
                        TotalIzinDetail::insert($dataInsertTotalIzinDetail);
                    }else{
                        #Alfa
                        // $this->dataTotalPresensi[$indexTotalPegawai]['alfa']++;
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
                        'tanggal_datang' => null,
                        'tanggal_istirahat' => null,
                        'tanggal_pulang' => null,
                    ]);

                }else{
                    #Piket
                    if($this->checkHariLibur()){
                        array_push($status,"7");
                    }
                    $shift = $presensi->kode_jam_kerja ?? $presensi->kode_shift;
                    if($this->existingTelat($presensi->tanggal_datang,$shift)){
                        #Telat
                        // $this->dataTotalPresensi[$indexTotalPegawai]['telat']++;
                        if(!$this->existingTotalDetail($this->dateNow,2)){
                            $status = ["2"];
                            if($this->existingPulangCepat($presensi->tanggal_pulang,$shift)){
                                array_push($status,"6");
                            }else{
                                if($presensi->tanggal_pulang == null){
                                    #Tanpa Absen Pulang
                                    array_push($status,"5");
                                }
                            }

                        }
                    }else{
                        #Masuk
                        array_push($status,"1");
                        if($presensi->tanggal_pulang == null){
                            #Tanpa Absen Pulang
                            array_push($status,"5");
                        }else{
                            if($this->existingPulangCepat($presensi->tanggal_pulang,$shift)){
                                #Pulang Cepat
                                array_push($status,"6");
                            }
                        }
                        // $this->dataTotalPresensi[$indexTotalPegawai]['masuk']++;
                    }

                    if(!$this->existingTotalDetail($this->dateNow,1)){
                        array_push($dataInsertTotalPresensiDetail,[
                            'nip' => $pegawai->nip,
                            'tanggal' => $this->dateNow,
                            'status' => implode(",",$status),
                            'kode_cuti' => null,
                            'periode_bulan' => $this->periodeBulan,
                            'tanggal_datang' => $presensi->tanggal_datang,
                            'tanggal_istirahat' => $presensi->tanggal_istirahat,
                            'tanggal_pulang' => $presensi->tanggal_pulang,
                        ]);
                    }
                }
                // dd($this->dataTotalPresensi);
                // TotalPresensi::where('nip',$pegawai->nip)->update($this->dataTotalPresensi[$indexTotalPegawai]);

            }
            // dd($dataInsertTotalPresensiDetail);

            // TotalPresensiDetail::insert($dataInsertTotalPresensiDetail);

            # UPDATE APP STATUS FUNCTION
            // AppStatusFunction::where('name','calculate_presensi')->update(['value' => 1]);
            // $this->dataPresensi->update(['hitung',1]);
            return $dataInsertTotalPresensiDetail;

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
            $jam_tepat_pulang = strtotime($shift->jam_tepat_pulang);
            $jamTepatNToleransi = $this->date." ".date("H:i:s", strtotime("-{$shift->toleransi_pulang} minutes",$jam_tepat_pulang));
            // if($this->date == "2023-06-26"){
            //     dd($jamTepatNToleransi,$tanggal_pulang,date("H:i:s",$jam_tepat_pulang), date("Y-m-d H:i:s", strtotime($tanggal_pulang)) <= date("Y-m-d H:i:s",strtotime($jamTepatNToleransi)));
            // }
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
        // dd($tanggal);
        $this->dataTotalPresensiDetail->chunk(100,function($data)use($tanggal,$status){
            foreach ($data as $presensiDetail) {
                if($tanggal == $presensiDetail->tanggal && $status == $presensiDetail->status){
                    return true;
                }
            }
        });
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


        # Jam Kerja
        foreach ($this->mdJamKerja as $jamKerja) {
            if($kode_shift == $jamKerja->kode){
                // dd($kode_shift);
                return $jamKerja;
            }
        }

        # Jam Shift
        foreach ($this->mdShifts as $shift) {
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
    function getLastMonthNow():array{
        $lastMonth = date("Y-m-01", strtotime("-1 month"));
        $currentMonth = date("Y-m-d");

        return ["$lastMonth","$currentMonth"];
    }
}
