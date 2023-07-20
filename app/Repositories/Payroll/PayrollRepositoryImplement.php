<?php

namespace App\Repositories\Payroll;

use App\Models\Master\Payroll\Absensi;
use App\Models\User;
use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Payroll;
use App\Models\Payroll\DaftarKurangPayroll;
use App\Models\Payroll\DaftarTambahPayroll;
use App\Models\Payroll\GeneratePayroll;
use App\Models\Presensi\TotalIzinDetail;
use App\Models\Presensi\TotalPresensiDetail;
use App\Repositories\Pegawai\PegawaiRepository;

class PayrollRepositoryImplement extends Eloquent implements PayrollRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property GeneratePayroll|mixed $mGenereatePayroll;
    */
    protected $pegawaiRepository;
    protected $mGeneratePayroll;
    protected $mTotalPresensiDetail;
    protected $mTotalIzinDetail;
    protected $mAbsensiDatang;
    protected $mAbsensiPulang;
    protected $daftarKurangPayroll;
    protected $daftarTambahPayroll;

    protected $bulan; # Bulan
    protected $tahun; # Tahun
    public function __construct(
        GeneratePayroll $mGeneratePayroll,
        TotalPresensiDetail $mTotalPresensiDetail,
        TotalIzinDetail $mTotalIzinDetail,
        PegawaiRepository $pegawaiRepository,
        Absensi $mAbsensi,
        DaftarKurangPayroll $daftarKurangPayroll,
        DaftarTambahPayroll $daftarTambahPayroll,
    )
    {
        $this->pegawaiRepository = $pegawaiRepository;
        $this->mGeneratePayroll = $mGeneratePayroll;
        $this->daftarKurangPayroll = $daftarKurangPayroll;
        $this->daftarTambahPayroll = $daftarTambahPayroll;
        $this->mTotalPresensiDetail = $mTotalPresensiDetail;
        $this->mTotalIzinDetail = $mTotalIzinDetail;
        $this->mAbsensiDatang = $mAbsensi->where('keterangan',1)->get();
        $this->mAbsensiPulang = $mAbsensi->where('keterangan',2)->get();
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
    function hitungPayroll(){
        dd();
        // $this->calculatePresensi(28);

    }
    function hitungTunjangan(){
        $tunjangan = [];
        foreach ($this->daftarTambahPayroll as $key => $value) {
            # Cek is_periode
            if($value->is_periode == 1){
                # cek bulan dan tahun
                if($value->bulan == $this->bulan && $value->tahun == $this->tahun){
                    # Mendapatkan NIP
                    $nipArray = $this->getKeterangan($value->keterangan,$value);
                    foreach ($nipArray as $nip) {
                        $tunjangan[] = [
                            'nip' => $nip,
                            'kode_tambahan' => $value->kode_tambah,
                            'keterangan' => $value->tunjangan?->nama,
                        ];
                    }
                }
            }
        }
    }
    function hitungBonus(){

    }
    function hitungPotongan($nip){
        $daftarPotongan = $this->daftarKurangPayroll->get();
        $potongan = [];
        #semua pegawai
        foreach ($daftarPotongan as $key => $dp) {
            $potongan[] = [
                'keterangan'=>$dp->kurang?->nama,
                'kode_kurang'=>$dp->kode_kurang,
                'nip'=>$nip,
                'nilai'=>$dp->kurang?->nilai
            ];
        }
    }
    function calculatePresensi($nip){
        $pegawai = $this->pegawaiRepository->getFirstPegawai($nip);

        // $pegawai->load('jamKerja','shift');

        $totalAbsen = $this->rekapAbsen($pegawai,1,26,25); #telat dan cepat pulang
        $telat = $totalAbsen['telat'];
        $cepatPulang = $totalAbsen['pulangCepat'];
        #dd($cepatPulang);
        $persenTelat = $telat['menit']*$this->pengaliPulang($telat['menit']);
        $persenPulangCepat = $cepatPulang['menit']*$this->pengaliPulang($cepatPulang['menit']);
        # sudah dapat persen absen

        return $persenTelat+$persenPulangCepat;
    }
    function rekapAbsen($pegawai,$datePreviousInMonthStart = 0,$datePreviousInMonthEnd = 0,$dateForMonthNow) {

        # Bikin hari bulan lalu tgl 26 sampai end
        $year = date("Y");
        $currentMonth = date('m'); // Mendapatkan angka bulan saat ini (misalnya, 06 untuk bulan Juni)
        $previousMonth = date('m', strtotime('-1 month'));
        $daysInCurrentMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $year); // Menghitung total tanggal dalam bulan sebelumnya
        $daysInPreviousMonth = cal_days_in_month(CAL_GREGORIAN, $previousMonth, $year); // Menghitung total tanggal dalam bulan sebelumnya

        $rangedaysIncurrentMonth = range($datePreviousInMonthStart,$datePreviousInMonthEnd);
        $rangedaysInPreviousMonth = range($dateForMonthNow,$daysInPreviousMonth);
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

        $rekapAbsensi = $this->mTotalPresensiDetail->where('nip',$pegawai->nip)->whereIn('tanggal',$whereTanggal)->get();
        $rekapIzin = $this->mTotalIzinDetail->where('nip',$pegawai->nip)->whereIn('tanggal',$whereTanggal)->get();
        // dd($rekapAbsensi);
        $pulangCepat = 0;
        $pulangCepatMenit = 0;
        $telat = 0;
        $telatMenit = 0;
        $izin = $rekapIzin->count();

        $jamKerja = $pegawai->jamKerja->where('is_akhir',1)->first();
        $shift = $pegawai->shift->where('is_akhir',1)->first();

        foreach ($rekapAbsensi as $absen) {
            $jamKerja = $jamKerja ?? $shift;
            $status = explode(",",$absen->status);
            if(in_array(2,$status)){
                $telat++;
                $telatMenit += hitungTelat($absen?->tanggal." ".$jamKerja?->jam_tepat_pulang,$absen?->tanggal_pulang,$jamKerja?->toleransi);
            }
            if(in_array(6,$status)){
                $pulangCepat++;
                $pulangCepatMenit += hitungCepatPulang($absen?->tanggal." ".$jamKerja?->jam_tepat_pulang,$absen?->tanggal_pulang);
            }
        }

        return [
            'pulangCepat' => ['menit'=>$pulangCepatMenit,'jumlah'=>$pulangCepat],
            'telat' => ['menit'=>$telatMenit,'jumlah'=>$telat],
            'izin' => $izin,
        ];
    }
    function pengaliPulang($menit){
        $no = 0;
        foreach ($this->mAbsensiPulang as $i => $value) {

            if(($i+1) < $this->mAbsensiPulang->count()){
                if($menit >= $value->menit && $menit <= $this->mAbsensiPulang[$i+1]->menit){
                    return $value->pengali;
                }
            }else{
                if($menit >= $value->menit){
                    return $value->pengali;
                }
            }
        }
        // dd($no);
        return 0;
    }
    function hitungGajiDariPersen($totalGaji,$persen){

    }

    #Function Support
    function getKeterangan($keterangan,$daftarTambahPayroll){
        switch ($keterangan) {
            case '1': # Pegawai Tertentu
                return explode(",",$daftarTambahPayroll->kode_keterangan);
            case '2': # Jabatan Terpilih
                return $this->pegawaiRepository->getPegawaiWhereJabatan($daftarTambahPayroll->kode_keterangan)->pluck('nip');
            case '3': # Level Jabatan
                return $this->pegawaiRepository->getPegawaiWhereLevelJabatan($daftarTambahPayroll->kode_keterangan)->pluck('nip');
            case '4': # Divisi Kerja
                return $this->pegawaiRepository->getPegawaiWhereDivisiKerja($daftarTambahPayroll->kode_keterangan)->pluck('nip');
                default:
                # code...
                break;
        }
    }
}
