<?php

use App\Models\Master\HariLibur;
use App\Models\Master\Payroll\Absensi;
use App\Models\Master\Shift;
use App\Models\MJamKerja;
use App\Models\Pegawai\DataPengajuanCuti;
use App\Models\Pegawai\DataPresensi;
use App\Models\Presensi\TotalPresensiDetail;
use Illuminate\Support\Facades\Cache;

function getPresensi($date){
    $pd = Cache::get("presensi-datang-$date");
    $pp = Cache::get("presensi-pulang-$date");
    // dd($pp["00306"]);
    $datasPd = collect($pd);
    $datasPp = collect($pp);
    $datas = [];
    foreach ($datasPd as $key => $data) {
        $dataMerge = $datasPp->get($key);
        unset($dataMerge['kode_shift']);
        unset($data['kode_shift']);
        if($dataMerge){
            $datas[] = collect($data)->merge($dataMerge)->toArray();
        }else{
            $datas[] = collect($data)->merge([
                'foto_pulang' => null,
                'kordinat_pulang' => null,
                'tanggal_pulang' => null
            ])->toArray();
            // dd($dataMerge,$datas,$data);
        }
    }
    // dd($datas);
    return $datas;
}
function check_libur($tanggal)
{
    $libur = HariLibur::where('tanggal_mulai', '<=', $tanggal)->where('tanggal_selesai', '>=', $tanggal)->count();
    if($libur > 0){
        return true;
    }else{
        return false;

    }
}

function hari_kerja($bulan, $tahun)
{
    $number = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);

    $hari = 0;
    for ($i = 1; $i <= $number; $i++) {
        // Hari kerja
        $hari_angka = date("w", strtotime("$tahun-$bulan-$i"));

        // Hari Libur Nasional
        $hari_libur = check_libur("$tahun-$bulan-$i");
        if ($hari_angka != 0 && $hari_angka != 6 && $hari_libur != true) {
            $hari += 1;
        }
    }

    return $hari;
}

function kehadiran($nip, $bulan, $tahun)
{

    $total_izin = 0;
    $whereNotIn = [];

    $perizinan = DataPengajuanCuti::where(function($qr) use($bulan, $tahun){
                        $qr->where(function($q) use($bulan, $tahun){
                            $q->whereMonth('tanggal_mulai', $bulan)
                            ->whereYear("tanggal_mulai", $tahun);
                        })->orWhere(function($qw)  use($bulan, $tahun){
                            $qw->whereMonth('tanggal_selesai', $bulan)
                            ->whereYear("tanggal_selesai", $tahun);
                        });
                    })
                    ->where('nip', $nip)
                    ->where('status', 1)
                    ->get();

    foreach ($perizinan as $key => $izin) {
        $tanggal = getBetweenDates($izin->tanggal_mulai, $izin->tanggal_selesai);
        foreach ($tanggal as $t) {
            $hari_angka = date("w", strtotime("$t"));
            $hari_libur = check_libur(date("Y-m-d", strtotime($t)));

            if ($hari_angka != 0 && $hari_angka != 6 && $hari_libur != true && in_array($t, $whereNotIn) == false) {
                array_push($whereNotIn, $t);
            }
        }
    }

    $total_izin = count($whereNotIn);

    if (count($whereNotIn) > 0) {
        $whereNotInString = arrayToString($whereNotIn);
    } else {
        $whereNotInString = false;
    }

    $kehadiran = DataPresensi::select('tanggal_datang', 'tanggal_istirahat', 'tanggal_pulang', 'created_at', 'kode_shift','kode_jam_kerja')
                    ->whereMonth('created_at', $bulan)
                    ->whereYear("created_at", $tahun)
                    ->where('nip', $nip)
                    ->when($whereNotInString, function ($qr, $whereNotInString) {
                        $qr->whereRaw("DATE(created_at) NOT IN ($whereNotInString)");
                    })
                    ->get();

    $hari_kerja = hari_kerja($bulan, $tahun);
    $total_telat_datang = [];
    $total_telat_pulang = [];
    $total_alfa = 0;
    $absen_libur = 0;
    $tanggal_dulicate = [];
    $shift_id = "";
    $shift =  new Shift();
    foreach ($kehadiran as $hadir) {
        if(is_null($hadir->kode_jam_kerja)){
            if($shift_id != $hadir->kode_shift){
                $shift = get_shift($hadir->kode_shift);
                $shift_id = $hadir->kode_shift;
            }
        }else{
            if($shift_id != $hadir->kode_jam_kerja){
                $shift = get_jam_kerja($hadir->kode_jam_kerja);
                $shift_id = $hadir->kode_jam_kerja;

            }
        }

        $tanggal = date("Y-m-d", strtotime("$hadir->created_at"));
        if(!in_array($tanggal, $tanggal_dulicate)){

            array_push($tanggal_dulicate, $tanggal);

            // Hari kerja
            $hari_angka = date("w", strtotime("$hadir->created_at"));

            // Hari Libur Nasional
            $hari_libur = check_libur(date("Y-m-d", strtotime($hadir->created_at)));
            if ($hari_angka == 0 || $hari_angka == 6 || $hari_libur == true) {
                $absen_libur += 1;
            }

            if ($hadir->tanggal_datang != "" || $hadir->tanggal_istirahat != "" || $hadir->tanggal_pulang != "") {
                if ($hadir->tanggal_datang != "") {
                    //Pengurangan Telat
                    if (strtotime($hadir->tanggal_datang) >= strtotime(date("Y-m-d", strtotime($hadir->tanggal_datang)) . " " . $shift->jam_tepat_datang . ":59")) {
                        $dateTimeObject1 = date_create(date("Y-m-d", strtotime($hadir->tanggal_datang)) . " " . $shift->jam_tepat_datang . ":59");
                        $dateTimeObject2 = date_create($hadir->tanggal_datang);
                        $difference = date_diff($dateTimeObject1, $dateTimeObject2);
                        $telat_datang = $difference->h * 60;
                        $telat_datang += $difference->i;

                        array_push($total_telat_datang, perhitungan_persen_telat($telat_datang));
                    }
                }else{
                    array_push($total_telat_datang, perhitungan_persen_telat(255));
                }


                if ($hadir->tanggal_pulang != "") {
                    // Pengurangan Cepat Pulang
                    if (strtotime($hadir->tanggal_pulang) <= strtotime(date("Y-m-d", strtotime($hadir->tanggal_pulang)) . " " . $shift->jam_tepat_pulang . ":00")) {
                        $dateTimeObject1 = date_create(date("Y-m-d", strtotime($hadir->tanggal_pulang)) . " " . $shift->jam_tepat_pulang . ":00");
                        $dateTimeObject2 = date_create($hadir->tanggal_pulang);
                        $difference = date_diff($dateTimeObject1, $dateTimeObject2);
                        $telat_pulang = $difference->h * 60;
                        $telat_pulang += $difference->i;

                        array_push($total_telat_pulang, perhitungan_persen_telat($telat_pulang));
                    }
                }else{
                    array_push($total_telat_pulang, perhitungan_persen_telat(255));
                }
            }else{
                array_push($total_telat_datang, perhitungan_persen_telat(255));
                array_push($total_telat_pulang, perhitungan_persen_telat(255));
            }
        }
    }

    // Alfa
    if(count($tanggal_dulicate) < $hari_kerja){
        $total_alfa = ($hari_kerja - count($tanggal_dulicate) - $absen_libur);
    }

    return [
        'hari_kerja' => ($hari_kerja),
        'total_izin' => ($total_izin),
        'total_alfa' => ($total_alfa - $total_izin),
        'total_akhir' => ($hari_kerja - $total_alfa + $total_izin / $hari_kerja * 100),
        'total_telat_datang' => ($total_telat_datang),
        'total_telat_pulang' => ($total_telat_pulang),
    ];
}

    function kehadiran_pegawai($tanggal, $nip)
    {
        $data = DataPresensi::whereDate('created_at', $tanggal)->where('nip', $nip)->first();
        return $data;
    }

    function get_shift($kode_shift)
    {
        return Shift::where('kode_shift', $kode_shift)->first();
    }
    function get_jam_kerja($kode_jam_kerja)
    {
        return MJamKerja::where('kode_jam_kerja', $kode_jam_kerja)->first();
    }


    function perhitungan_persen_telat($menit, $keterangan = 1)
    {
        return Absensi::select('pengali', 'kode_tunjangan')->where('menit', '<=', $menit)->where('keterangan', $keterangan)->first();
    }
    function badgeApproval($text)
    {
        $color = '';
        switch (strtolower($text)) {
            case 'tolak':
                # code...
                $color = 'danger';
                break;
            case 'terima':
                # code...
                $color = 'success';
                break;
            case 'diajukan':
                # code...
                $color = 'info';
                break;
            case 'dihapus':
                # code...
                $color = 'warning';
                break;
            case 'ditambahkan':
                # code...
                $color = 'primary';
                break;
            default:
                $color = 'dark';
                break;
        }
        return '<span class="badge badge-'.$color.' ms-3 d-md-inline-block text-capitalize d-none">'.$text.'</span>';
    }


    function hitungTelat($jamTepatDatang,$jamDatang,$toleransi){
        // echo "$jamDatang, $jamTepatDatang";

        $jamTepatDatang = strtotime("+".(is_null($toleransi) ? "0 minutes" : $toleransi." minutes"),strtotime($jamTepatDatang));
        $jamDatang = strtotime($jamDatang);
        $result = 0;
        // dd(date("H:i:s", ($jamDatang-$jamTepatDatang)));
        if($jamDatang > $jamTepatDatang){
            $selisihDetik = abs($jamTepatDatang - $jamDatang);
            $selisihMenit = floor($selisihDetik / 60);

            return $selisihMenit;
        }
        return $result;
    }
    function hitungCepatPulang($jamTepatPulang,$jamPulang,$toleransi){
        if($jamPulang){
            // dd($jamPulang, $jamTepatPulang, $jamPulang < $jamTepatPulang);
            $jamTepatPulang = strtotime("-".(is_null($toleransi) ? "0 minutes" : $toleransi." minutes"),strtotime($jamTepatPulang));;
            $jamPulang = strtotime($jamPulang);
            $result = 0;

            if($jamPulang < $jamTepatPulang){
                $selisihDetik = abs($jamTepatPulang - $jamPulang);
                $selisihMenit = floor($selisihDetik / 60);

                return $selisihMenit;
            }
            return $result;
        }else{
            return 0;
        }
    }
    function shiftMalam($jamAwal, $jamAkhir) {
        $waktuAwal = strtotime($jamAwal);
        $waktuAkhir = strtotime($jamAkhir);

        if ($waktuAwal === false || $waktuAkhir === false) {
            return false; // Format waktu tidak valid
        }

        $jamAwalTengahMalam = strtotime("00:00:00");
        $jamAkhirTengahMalam = strtotime("23:59:59");

        if (($waktuAwal < $jamAwalTengahMalam && $waktuAkhir > $jamAkhirTengahMalam) || ($waktuAwal > $waktuAkhir)) {
            return true; // Melewati tengah malam
        }

        return false; // Tidak melewati tengah malam
    }
