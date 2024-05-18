<?php

namespace App\Repositories\Presensi;

use App\Models\MAktifitas;
use App\Models\Pegawai\DataPresensi;
use App\Models\Pegawai\DataVisit;
use Carbon\Carbon;
use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Presensi;
use App\Models\Presensi\TotalPresensiDetail;
use Illuminate\Support\Facades\Cache;

class PresensiRepositoryImplement extends Eloquent implements PresensiRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property DataPresensi|mixed $model;
    */
    protected $mDataPresensi;
    protected $totalPresensiDetail;
    protected $date;

    public function __construct(
        DataPresensi $mDataPresensi,
        TotalPresensiDetail $totalPresensiDetail,
    )
    {
        $this->mDataPresensi = $mDataPresensi;
        $this->totalPresensiDetail = $totalPresensiDetail;
        $this->date = date("Y-m-d");
        // $this->date = "2023-08-04";
    }
    function presensiDay($nip){
        $dataDatang = $this->getPresensiDatang($nip);
        $dataPulang = $this->getPresensiPulang($nip);
        $dataDatang = $dataDatang ? (object)$dataDatang : null;
        $dataPulang = $dataPulang ? (object)$dataPulang : null;
        // dd($data);
        # cari shift nya
        # ambil jam pulang
        # hitung
        $dataVisit = DataVisit::where('nip',$nip)->whereDate('created_at', now())->get()->count();
        $dataAktifitas = MAktifitas::where('nip',$nip)->whereDate('created_at', now())->get()->count();
        // dd($dataVisit,$data);
        $data = [
            'nip' => $nip,
            'datang' => $dataDatang?->tanggal_datang ? date("H:i:s", strtotime($dataDatang->tanggal_datang)) : "-",
            'pulang' => $dataPulang?->tanggal_pulang ? date("H:i:s", strtotime($dataPulang->tanggal_pulang)) : "-",
        ];

        $data['visit'] = $dataVisit;
        $data['aktifitas'] = $dataAktifitas;
        return $data;
    }

    function getPresensiDay($nip){
        # ambil absen hari ini
        // $presensiNip = $this->mDataPresensi->where('nip', $nip);
        // # cek apakah hari ini ada?
        // $presensiNow = $presensiNip->whereDate('created_at', now())->first(["tanggal_datang"]);
        // if(is_null($presensiNow)){
        //     # jika tidak ada maka cari absen kemaren
        //     $presensiNow = $presensiNip->whereDate('created_at','=', date('Y-m-d',strtotime("-1 days")))->first();
        //     // dd($data);
        //     $jamDatang = date("H:i:s",strtotime($presensiNow?->tanggal_datang));
        //     # cari shift nya
        //     # $shift = $data->user->shift->where('is_akhir',1)->first() ?? $data->user->jamKerja->where('is_akhir',1)->first();
        //     // dd($shift->shift);
        //     # dd($this->hitungRangeJam($shift->shift->jam_tepat_pulang,"23:59:59"),$shift->shift->jam_tepat_pulang,$shift->shift);
        //     # hitung apakah shift lebih dari 8 jam dengan perbandingan jam 23:59:59
        //     # dd($this->hitungRangeJam($jamDatang,"23:59:59"),$jamDatang,$data);

        //     if(hitungRangeJam($jamDatang,"23:59:59") >= 8){
        //         $presensiNow = null;
        //     }
        // }
    }
    function getPresensiDatang($nip){
        $presensiNow = Cache::get("presensi-datang");
        return isset($presensiNow[$nip]) ? $presensiNow[$nip]: null;
    }
    function getPresensiPulang($nip){
        $presensiNow = Cache::get("presensi-pulang");
        return isset($presensiNow[$nip]) ? $presensiNow[$nip]: null;
    }
    function getStatPresensi($nip){
        $bulan = (int)request('bulan');
        $tahun = request('tahun');

        $jumlahHari = lastDayInThisMonth($tahun,$bulan);
        $presensi = $this->totalPresensiDetail->whereNip($nip)->whereBetween('tanggal',[$tahun."-".addZero($bulan)."-01",$tahun."-".addZero($bulan)."-".$jumlahHari]);

        $hadir = clone $presensi;
        $telat = clone $presensi;
        $izin = clone $presensi;
        $tap = clone $presensi;
        $pc = clone $presensi;
        $libur = clone $presensi;
        $alfa = clone $presensi;
        $cuti = clone $presensi;
        $lembur = clone $presensi;

        $hadir = $hadir->withHadir()->get()->count();
        $telat = $telat->withTelat()->get()->count();
        $izin = $izin->withIzin()->get()->count();
        $tap = $tap->withTAP()->get()->count();
        $pc = $pc->withPC()->get()->count();
        $libur = $libur->withLibur()->get()->count();
        $alfa = $alfa->withAlfa()->get()->count();
        $cuti = $cuti->withCuti()->get()->count();
        $lembur = $lembur->withLembur()->get()->count();

        $percentHadir = hitungPersentase($hadir,$jumlahHari,0);
        $percentTelat = hitungPersentase($telat,$jumlahHari,0);
        $percentIzin = hitungPersentase($izin,$jumlahHari,0);
        $percentTAP = hitungPersentase($tap,$jumlahHari,0);
        $percentPC = hitungPersentase($pc,$jumlahHari,0);
        $percentLibur = hitungPersentase($libur,$jumlahHari,0);
        $percentAlfa = hitungPersentase($alfa,$jumlahHari,0);
        $percentCuti = hitungPersentase($cuti,$jumlahHari,0);
        $percentLembur = hitungPersentase($lembur,$jumlahHari,0);

        return [
            "hadir" => $hadir,
            "percent_hadir" => $percentHadir,
            "telat" => $telat,
            "percent_telat" => $percentTelat,
            "izin" => $izin,
            "percent_izin" => $percentIzin,
            "tap" => $tap,
            "percent_tap" => $percentTAP,
            "pc" => $pc,
            "percent_pc" => $percentPC,
            "libur" => $libur,
            "percent_libur" => $percentLibur,
            "alfa" => $alfa,
            "percent_alfa" => $percentAlfa,
            "cuti" => $cuti,
            "percent_cuti" => $percentCuti,
            "lembur" => $lembur,
            "percent_lembur" => $percentLembur,
        ];
    }
}
