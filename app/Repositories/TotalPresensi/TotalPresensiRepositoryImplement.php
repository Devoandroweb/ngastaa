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
use App\Models\StatusCalculate;
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
        $this->dataTotalPresensi = $mdTotalPresensi->where('periode_bulan',$this->periodeBulan)->get(['nip','masuk','telat','alfa'])->toArray();

        $this->dataTotalPresensiDetail = $mdTotalPresensiDetail
                ->whereBetween("tanggal",[$this->getLastMonthNow()]);

        $this->dataTotalIzin = $mdTotalIzin->where('periode_bulan',$this->periodeBulan)->get(['nip','kode_cuti','total','periode_bulan'])->toArray();
        $this->allPengajuanCuti = $mdPengajuanCuti->where('status',1)->get();
        $this->nipMasuk = [];



    }
    public function manualCaculate()
    {

        if($this->dataTotalPresensiDetail->get()->count() != 0){
            $this->maxDate = $this->dataTotalPresensiDetail->max('tanggal');
            $this->maxDate = date("Y-m-d",strtotime($this->maxDate."+1 days"));
        }else{
            $minDate = $this->mDataPresensi->where('periode_bulan','!=',null)->where('periode_bulan','!=',"")->get()->min('periode_bulan');
            if($minDate != null){
                $this->maxDate = $minDate."-01";
            }else{
                return 0; # Data Absen Kosong
            }
        }
        // dd($this->maxDate);
        $statusCacl = StatusCalculate::first();
        $dateStart = date("Y-m-d",strtotime("-1 days"));
        $dateEnd = date("Y-m-d",strtotime("-1 days"));
        // $dateStart = "2024-05-02";
        // $dateEnd = "2024-05-03";
        $limit = $statusCacl->limits;
        $offset = $statusCacl->offset;
        $nip = request('nip');
        $nip = $nip != "" ? explode(",",$nip) : [];

        # Check apakah tanggal nya sama, jika sama jangan hitung
        // if($dateStart == $dateEnd){
        //     return 2; # Tanggal Masih Sama
        // }
        # hitung
        $tanggalBulan = arrayTanggal($dateStart,$dateEnd);
        // dd($tanggalBulan);
        // $tanggalBulan = [date("Y-m-d",strtotime("-1 days"))];

        $this->allPegawai = $this->pegawaiRepository->allPegawai();
        if($nip){
            $this->allPegawai = $this->allPegawai->whereIn("nip",$nip);
        }
        if($limit){
            $this->allPegawai = $this->allPegawai->limit($limit)->offset($offset);
        }
        $this->allPegawai = $this->allPegawai->pluck('nip')->toArray();
        $nipNotCalc = $this->dataTotalPresensiDetail->whereIn('tanggal',$tanggalBulan)->pluck("nip")->toArray();
        $this->allPegawai = array_diff($this->allPegawai,$nipNotCalc);
        // dd($this->allPegawai,$tanggalBulan,$nipNotCalc);
        $dataInsert = collect([]);

        foreach ($tanggalBulan as $date) {

            # check pegawai yg belum di hitung

            $this->date = $date;
            $this->dateNow = $date;
            $this->periodeBulan = date("Y-m",strtotime($date));
            // $this->dataPresensi =  DataPresensi::where("tanggal_datang","!=",null)->whereDate('created_at', '=', $this->date)->where('hitung',0);
            $this->dataPresensi2 = DataPresensi::whereDate('created_at', $this->date)->where('hitung',0)->get(['nip','tanggal_datang','tanggal_pulang','kode_jam_kerja','kode_shift','tanggal_istirahat']);
            $dataInsert = collect($dataInsert)->concat($this->calculatePresensi());
        }
        // dd($dataInsert);
        TotalPresensiDetail::insert($dataInsert->toArray());
        if($dateStart && $dateEnd){
            $updateOffset = $statusCacl->offset+$statusCacl->limits;
            if($updateOffset>$this->pegawaiRepository->allPegawai()->count()){
                $updateOffset = 0;
            }
            $statusCacl->update([
                "limits"=>50,
                "offset"=>$updateOffset,
                "date_start"=>$dateStart,
                "date_end"=>$dateEnd,
                "time"=>date("Y-m-d H:i:s"),
            ]);
        }
        return 1;
    }
    function calculatePresensi()
    {

            $dataInsertTotalPresensiDetail = [];
            $dataInsertTotalIzinDetail = [];

            foreach ($this->allPegawai as $pegawai) {
                #Cek pegawai di data_presensi
                $presensi = $this->existingPresensi($pegawai);
                $status = [];

                if($presensi == null){
                    if($this->checkHariLibur()){
                        continue;
                    }
                    $izin = $this->existingIzin($pegawai);
                    if($izin != null){
                        #Izin
                        if(!$this->existingTotalDetail($this->dateNow,4)){
                            array_push($status,"4");
                        }

                        array_push($dataInsertTotalIzinDetail,[
                            'nip' => $pegawai,
                            'tanggal' => $this->dateNow,
                            'kode_cuti' => $izin->kode_cuti,
                            'periode_bulan' => $this->periodeBulan,
                        ]);

                        TotalIzinDetail::insert($dataInsertTotalIzinDetail);
                    }else{
                        #Alfa
                        if(!$this->existingTotalDetail($this->dateNow,3)){
                            array_push($status,"3");
                        }
                    }
                    array_push($dataInsertTotalPresensiDetail,[
                        'nip' => $pegawai,
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

                    }

                    if(!$this->existingTotalDetail($this->dateNow,1)){
                        array_push($dataInsertTotalPresensiDetail,[
                            'nip' => $pegawai,
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

            }
            // dd($dataInsertTotalPresensiDetail);
            return $dataInsertTotalPresensiDetail;

    }

    function existingPresensi($nip){
        return $this->dataPresensi2->where('nip',$nip)->first();
    }
    function existingTelat($tanggal_datang, $kode_shift)
    {
        $shift = $this->searchShift($kode_shift);

        // dd($shift);
        if($shift != null){

            $jam_tepat_datang = strtotime($shift->jam_tepat_datang);
            $jamTepatNToleransi = $this->date." ".date("H:i:s", strtotime("+{$shift->toleransi_datang} minutes",$jam_tepat_datang));

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

            if(date("Y-m-d H:i:s", strtotime($tanggal_pulang)) <= date("Y-m-d H:i:s",strtotime($jamTepatNToleransi))){
                return true;
            }
        }
        return false;
    }
    function existingIzin($nip){


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
        $hariLibur = $this->hariLibur($this->date);

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
                // dd($jamKerja);
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
    function hariLibur($tanggal) {
        $hariLibur = ['2023-05-18']; // Mendapatkan kode hari saat ini (1-7, dengan 1 adalah Senin dan 7 adalah Minggu)

        if (in_array($tanggal,$hariLibur)) {
            return true;
        }
        return false;
    }
}
