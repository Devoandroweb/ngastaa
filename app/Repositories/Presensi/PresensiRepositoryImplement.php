<?php

namespace App\Repositories\Presensi;

use App\Models\Pegawai\DataPresensi;
use App\Models\Pegawai\DataVisit;
use Carbon\Carbon;
use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Presensi;

class PresensiRepositoryImplement extends Eloquent implements PresensiRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property DataPresensi|mixed $model;
    */
    protected $mDataPresensi;

    public function __construct(
        DataPresensi $mDataPresensi
    )
    {
        $this->mDataPresensi = $mDataPresensi;
    }
    function presensiDay($nip){
        $data = $this->getPresensiDay($nip);
        # cari shift nya
        # ambil jam pulang
        # hitung
        $dataVisit = DataVisit::where('nip',$nip)->whereDate('created_at', date('Y-m-d'))->first();
        // dd($dataVisit,$data);
        if($data != null || $dataVisit != null){
            $data = [
                'nip' => $nip,
                'datang' => $data?->tanggal_datang != null ? date("H:i:s",strtotime($data->tanggal_datang)) : "-",
                'istirahat' => $data?->tanggal_istirahat != null ? date("H:i:s",strtotime($data->tanggal_istirahat)) : "-",
                'pulang' => $data?->tanggal_pulang != null ? date("H:i:s",strtotime($data->tanggal_pulang)) : "-",
                'visit' => $dataVisit?->check_in != null ? date("H:i:s",strtotime($dataVisit->check_in)) : "-",
            ];
        }else{
            $data = [
                'nip' => $nip,
                'datang' => "-",
                'istirahat' => "-",
                'pulang' => "-",
                'visit' => "-",
            ];
        }
        return $data;
    }
    function hitungRangeJam($jamA, $jamB)
    {
        // Parsing jam A dan jam B menjadi objek Carbon
        $carbonJamA = Carbon::createFromFormat('H:i:s', $jamA);
        $carbonJamB = Carbon::createFromFormat('H:i:s', $jamB);

        // Pastikan $carbonJamA selalu merupakan jam awal dan $carbonJamB selalu merupakan jam akhir
        if ($carbonJamB < $carbonJamA) {
            $temp = $carbonJamA;
            $carbonJamA = $carbonJamB;
            $carbonJamB = $temp;
        }

        // Hitung selisih jam antara jam awal dan jam akhir
        $rangeJam = $carbonJamA->diff($carbonJamB);

        // Format output range jam
        return (int)$rangeJam->format('%H');
    }
    function getPresensiDay($nip){
        # ambil absen hari ini
        $data = $this->mDataPresensi->where('nip', $nip)->whereDate('created_at', date('Y-m-d'))->latest()->first();
        # cek apakah hari ini ada?

        if(is_null($data)){
            # jika tidak ada maka cari absen kemaren
            $data = $this->mDataPresensi->where('nip', $nip)->whereDate('created_at', date('Y-m-d',strtotime("-1 days")))->latest()->first();
            // dd($data);
            $jamDatang = date("H:i:s",strtotime($data?->tanggal_datang));
            # cari shift nya
            # $shift = $data->user->shift->where('is_akhir',1)->first() ?? $data->user->jamKerja->where('is_akhir',1)->first();
            // dd($shift->shift);
            # dd($this->hitungRangeJam($shift->shift->jam_tepat_pulang,"23:59:59"),$shift->shift->jam_tepat_pulang,$shift->shift);
            # hitung apakah shift lebih dari 8 jam dengan perbandingan jam 23:59:59
            // dd($this->hitungRangeJam($jamDatang,"23:59:59"),$jamDatang,$data);

            if($this->hitungRangeJam($jamDatang,"23:59:59") >= 8){
                $data = null;
            }
        }
        return $data;
    }
    // Write something awesome :)
}
