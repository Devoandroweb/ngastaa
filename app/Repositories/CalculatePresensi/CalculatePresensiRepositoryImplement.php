<?php

namespace App\Repositories\CalculatePresensi;

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

class CalculatePresensiRepositoryImplement extends Eloquent implements CalculatePresensiRepository{

    protected $pegawaiRepository;
    protected $mDataPresensi;
    protected $mdTotalPresensi;
    protected $mdShifts;
    protected $mdJamKerja;
    protected $mdPengajuanCuti;
    protected $mdTotalIzin;

    protected $allPegawai;
    protected $dataPresensi;
    protected $dataPresensiChoose;
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
        $this->allPengajuanCuti = $mdPengajuanCuti->where('status',1);
        $this->nipMasuk = [];
    }
    public function manualCalculate()
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
        // $statusCacl = StatusCalculate::first();
        $dateStart = $this->maxDate; # maksimal tanggal total detail presensi
        $dateEnd = date("Y-m-d");

        # Check apakah tanggal nya sama, jika sama jangan hitung
        if($dateStart == $dateEnd){
            return 2; # Tanggal Masih Sama
        }
        # hitung
        $tanggalBulan = arrayTanggal($dateStart,$dateEnd);
        $tanggalBulan = [collect($tanggalBulan)->first(),collect($tanggalBulan)->last()];
        // dd($tanggalBulan);
        #calculate pegawai tidak masuk/izin
        $this->allPengajuanCuti = $this->allPengajuanCuti->whereBetween("tanggal_mulai",$tanggalBulan)->get(["nip","kode_cuti","tanggal_mulai","tanggal_selesai"]);

        $this->dataPresensi = DataPresensi::whereBetween('created_at', $tanggalBulan)->orderByDesc("tanggal_datang")->get(['nip','created_at','tanggal_datang','tanggal_pulang','kode_jam_kerja','kode_shift','tanggal_istirahat']);

        // dd($tanggalBulan,$this->dataPresensi->toArray());
        # calculate pegawai masuk/telat/tap
        $this->dataPresensi = clone $this->dataPresensi->map(function($item){
            $hari = $item->created_at->format("N");
            $tanggal = $item->created_at->format("Y-m-d");
            $status = ["1"];
            $kodeCuti = null;
            if($this->existingTelat($item->hJamKerja($hari)->first(),$item->tanggal_datang)){
                #Telat
                array_push($status,"2");
            }
            if($item->tanggal_pulang == null){
                #Tanpa Absen Pulang
                array_push($status,"5");
            }else{
                if($this->existingPulangCepat($item->hJamKerja($hari)->first(),$item->tanggal_pulang)){
                    #Pulang Cepat
                    array_push($status,"6");
                }
            }
            if(in_array($hari,[6,7])){
                #piket
                array_push($status,"7");
            }
            $pegawaiCuti = $this->existingIzin($item->nip,$tanggal);
            if($pegawaiCuti){
                $kodeCuti = $pegawaiCuti->kode_cuti;
                array_push($status,"4");
            }
            $data = [
                'nip' => $item->nip,
                'tanggal' => $tanggal,
                'status' => implode(",",$status),
                'kode_cuti' => $kodeCuti,
                'periode_bulan' => $item->created_at->format("Y-m"),
                'tanggal_datang' => $item->tanggal_datang,
                'tanggal_pulang' => $item->tanggal_pulang,
            ];
            return $data;
        });
        // dd($this->dataPresensi);
        return $this->dataPresensi;
    }

    function existingTelat($jamKerja,$tanggal_datang)
    {

        if($jamKerja != null){
            $jam_tepat_datang = strtotime($jamKerja->jam_tepat_datang);
            $jamTepatNToleransi = $this->date." ".date("H:i:s", strtotime("+{$jamKerja->toleransi_datang} minutes",$jam_tepat_datang));
            // dd($this->date." ".date("H:i:s", strtotime($tanggal_datang)),$jamTepatNToleransi);
            if($this->date." ".date("H:i:s", strtotime($tanggal_datang)) >= $jamTepatNToleransi){
                return true;
            }
        }
        return false;
    }
    function existingPulangCepat($jamKerja,$tanggal_pulang)
    {
        if($jamKerja != null){
            $jam_buka_pulang = strtotime(date("Y-m-d ".$jamKerja->jam_buka_pulang));
            if(strtotime($tanggal_pulang) <= $jam_buka_pulang){
                return true;
            }
        }
        return false;
    }
    function existingIzin($nip,$date){
        $date = strtotime($date);
        $cutiPegawai = $this->allPengajuanCuti->firstWhere("nip",$nip);
        if($cutiPegawai){
            if(strtotime($cutiPegawai->tanggal_mulai) >= $date || strtotime($cutiPegawai->tanggal_selesai) >= $date){
                return $cutiPegawai;
            }
        }
        return null;
    }
    function getLastMonthNow():array{
        $lastMonth = date("Y-m-01", strtotime("-1 month"));
        $currentMonth = date("Y-m-d");

        return ["$lastMonth","$currentMonth"];
    }
}
