<?php

namespace App\Repositories\Payroll;

use App\Jobs\ProcessWaNotif;
use App\Models\Master\Payroll\Absensi;
use App\Models\User;
use Illuminate\Support\Str;
use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Payroll;
use App\Models\Payroll\DaftarBonusPayroll;
use App\Models\Payroll\DaftarKurangPayroll;
use App\Models\Payroll\DaftarTambahPayroll;
use App\Models\Payroll\DataPayroll;
use App\Models\Payroll\GeneratePayroll;
use App\Models\Payroll\PayrollKurang;
use App\Models\Payroll\PayrollTambah;
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
    protected $daftarBonusPayroll;

    protected $bulan; # Bulan
    protected $tahun; # Tahun
    protected $gajiPokok = 0;
    public function __construct(
        GeneratePayroll $mGeneratePayroll,
        TotalPresensiDetail $mTotalPresensiDetail,
        TotalIzinDetail $mTotalIzinDetail,
        PegawaiRepository $pegawaiRepository,
        Absensi $mAbsensi,
        DaftarKurangPayroll $daftarKurangPayroll,
        DaftarTambahPayroll $daftarTambahPayroll,
        DaftarBonusPayroll $daftarBonusPayroll,
    )
    {
        $this->pegawaiRepository = $pegawaiRepository;
        $this->mGeneratePayroll = $mGeneratePayroll;
        $this->daftarKurangPayroll = $daftarKurangPayroll->get();
        $this->daftarTambahPayroll = $daftarTambahPayroll->get();
        $this->daftarBonusPayroll = $daftarBonusPayroll->get();
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
    function hitungPayrollWithDivisi($kodeSkpd,$kodePayroll,$bulan,$tahun){
        if($kodeSkpd){
            $pegawais = $this->pegawaiRepository->allPegawaiWithRole($kodeSkpd)->get();
        }else{
            $pegawais = $this->pegawaiRepository->getAllPegawai()->get();
        }
        // dd("adoaskdoa",$pegawais);
        foreach ($pegawais as $pegawai) {
            $this->hitungPayroll($pegawai,$kodePayroll,$bulan,$tahun);
        }
    }
    function hitungPayroll($pegawai,$kodePayroll,$bulan,$tahun){

        $presentaseAbsen = 100 - $this->calculatePresensi($pegawai);
        $this->gajiPokok = $this->hitungGajiPokok($pegawai);

        $tunjangan = $this->hitungTunjangan($pegawai,$kodePayroll);
        $listTunjangan = $tunjangan['data'];
        $totalTunjangan = $tunjangan['total'];

        $bonus = $this->hitungBonus($pegawai,$kodePayroll);
        $listBonus = $bonus['data'];
        $totalBonus = $bonus['total'];

        $potongan = $this->hitungPotongan($pegawai,$kodePayroll);
        $listPotongan = $potongan['data'];
        $totalPotongan = $potongan['total'];
        // dd($bonus,$tunjangan,$potongan);
        # data_payroll (detail dari masing-masing record generate_payroll)
        $this->simpanDataPayroll($kodePayroll,$bulan,$tahun,$pegawai,$this->gajiPokok,$totalTunjangan,$totalBonus,$totalPotongan,$presentaseAbsen);
        # payroll_kurang (untuk menyimpan detail potongan payroll)
        $this->simpanPayrollTambah($listTunjangan);
        $this->simpanPayrollTambah($listBonus);
        # payroll_tambah (untuk menyimpan detail tambahan payroll)
        $this->simpanPayrollKurang($listPotongan);
        send_wa($pegawai->no_hp, 'Hallo, Payroll telah digenerate anda dapat memeriksa payroll anda, jika terdapat keselahan silahkan komunikasi ke HR paling lambat 3 hari setelah digenerate!');


    }
    # Save
    function simpanDataPayroll($kodePayroll,$bulan,$tahun,$pegawai,$gajiPokok,$totalTunjangan,$totalBonus,$totalPotongan,$presentaseAbsen){
        DataPayroll::create([
            'kode_payroll'=>$kodePayroll,
            'bulan'=>$bulan,
            'tahun'=>$tahun,
            'nip'=>$pegawai?->nip,
            'kode_tingkat'=>$pegawai?->getJabatan()?->kode_tingkat,
            'jabatan'=>$pegawai?->getNamaJabatan(),
            'divisi'=>$pegawai?->getNamaDivisi(),
            'gaji_pokok'=>$gajiPokok,
            'tunjangan'=>$totalTunjangan,
            'total_penambahan'=>$totalBonus,
            'total_potongan'=>$totalPotongan,
            'persen_kehadiran' => $presentaseAbsen,
            'total' => ($gajiPokok+$totalTunjangan+$totalBonus)-$totalPotongan
        ]);
    }
    function simpanPayrollTambah($data){
        return PayrollTambah::insert($data);
    }
    function simpanPayrollKurang($data){
        return PayrollKurang::insert($data);
    }
    function hitungGajiPokok($pegawai){
        return $pegawai->getJabatan()->gaji_pokok ?? 0;
    }
    function hitungTunjangan($pegawai,$kodePayroll){
        $tunjangan = [];
        $totalTunjangan = 0;
        // dd($this->daftarTambahPayroll);
        foreach ($this->daftarTambahPayroll as $key => $value) {
            if($value->keterangan != 0){
                $nipArray = $this->getKeteranganTambahPayroll($value->keterangan,$value);
            }else{
                $nipArray = $this->pegawaiRepository->getAllPegawai()->pluck('nip');
            }
            // dd($nipArray,$value);
            # Cek is_periode
            if($value->is_periode == 1){ # Tidak Selamanya
                # cek bulan dan tahun
                if($value->bulan == $this->bulan && $value->tahun == $this->tahun){
                    # Mendapatkan NIP
                    if(in_array($pegawai->nip,$nipArray)){
                        if($value->tunjangan?->satuan == 1){
                            $nilai = $this->hitungGajiDariPersen($value->tunjangan?->nilai);
                        }else{
                            $nilai = $value->tunjangan?->nilai;
                        }
                        // dd($nilai);
                        $tunjangan[] = [
                            'kode_payroll' => $kodePayroll,
                            'nip' => $pegawai->nip,
                            'kode_tambahan' => $value->kode_tambah,
                            'keterangan' => $value->tunjangan?->nama,
                            'nilai' => $nilai,
                        ];
                        $totalTunjangan += (int)$nilai;
                    }
                }
            }else{ # Selamanya
                if(in_array($pegawai->nip,$nipArray)){
                    if($value->tunjangan?->satuan == 1){
                        $nilai = $this->hitungGajiDariPersen($value->tunjangan?->nilai);
                    }else{
                        $nilai = $value->tunjangan?->nilai;
                    }

                    $tunjangan[] = [
                        'kode_payroll' => $kodePayroll,
                        'nip' => $pegawai->nip,
                        'kode_tambahan' => $value->kode_tambah,
                        'keterangan' => $value->tunjangan?->nama,
                        'nilai' => $nilai,
                    ];
                    $totalTunjangan += (int)$nilai;
                }
            }
        }
        return [
            'data' => $tunjangan,
            'total' => $totalTunjangan,
        ];
    }
    function hitungBonus($pegawai,$kodePayroll){
        $bonus = [];
        $totalBonus = 0;
        // dd($this->daftarTambahPayroll);
        foreach ($this->daftarBonusPayroll as $key => $value) {
            if($value->keterangan != 0){
                $nipArray = $this->getKeteranganTambahPayroll($value->keterangan,$value);
            }else{
                $nipArray = $this->pegawaiRepository->getAllPegawai()->pluck('nip');
            }
            # Cek is_periode
            if($value->is_periode == 1){ # Tidak Selamanya
                // dd($nipArray);
                # cek bulan dan tahun
                if($value->bulan == $this->bulan && $value->tahun == $this->tahun){
                    # Mendapatkan NIP
                    if(in_array($pegawai->nip,$nipArray)){
                        if($value->tambah?->satuan == 2){
                            $nilai = $this->hitungGajiDariPersen($value->tambah?->nilai);
                        }else{
                            $nilai = $value->tambah?->nilai;
                        }
                        // dd($nilai,$value->tambah?->satuan,$this->gajiPokok);
                        $bonus[] = [
                            'kode_payroll' => $kodePayroll,
                            'nip' => $pegawai->nip,
                            'kode_tambahan' => $value->kode_bonus,
                            'keterangan' => $value->tambah?->nama,
                            'nilai' => $nilai,
                        ];
                        $totalBonus += (int)$nilai;
                    }
                }
            }else{ # Selamanya
                if(in_array($pegawai->nip,$nipArray)){
                    if($value->tambah?->satuan == 1){
                        $nilai = $this->hitungGajiDariPersen($value->tambah?->nilai);
                    }else{
                        $nilai = $value->tambah?->nilai;
                    }

                    $bonus[] = [
                        'kode_payroll' => $kodePayroll,
                        'nip' => $pegawai->nip,
                        'kode_tambahan' => $value->kode_bonus,
                        'keterangan' => $value->tambah?->nama,
                        'nilai' => $nilai,
                    ];
                    $totalBonus += (int)$nilai;
                }
            }
        }
        return [
            'data' => $bonus,
            'total' => $totalBonus,
        ];
    }
    function hitungPotongan($pegawai,$kodePayroll){
        $potongan = [];
        $totalPotongan = 0;
        // dd($this->daftarTambahPayroll);
        foreach ($this->daftarKurangPayroll as $key => $value) {
            if($value->keterangan != 0){
                $nipArray = $this->getKeteranganKurangPayroll($value->keterangan,$value);
            }else{
                $nipArray = $this->pegawaiRepository->getAllPegawai()->pluck('nip')->toArray();
            }
            // dd($nipArray,$value);
            # Cek is_periode
            if($value->is_periode == 1){ # Tidak Selamanya
                # cek bulan dan tahun
                if($value->bulan == $this->bulan && $value->tahun == $this->tahun){
                    # Mendapatkan NIP
                    if(in_array($pegawai->nip,$nipArray)){
                        if($value->kurang?->satuan == 2){
                            $nilai = $this->hitungGajiDariPersen($value->kurang?->nilai);
                        }else{
                            $nilai = $value->kurang?->nilai;
                        }
                        // dd($nilai);
                        $potongan[] = [
                            'kode_payroll' => $kodePayroll,
                            'nip' => $pegawai->nip,
                            'kode_kurang' => $value->kode_kurang,
                            'keterangan' => $value->kurang?->nama,
                            'nilai' => $nilai,
                        ];
                        $totalPotongan += (int)$nilai;
                    }
                }
            }else{ # Selamanya
                // dd($pegawai,$nipArray);
                if(in_array($pegawai->nip,$nipArray)){
                    if($value->kurang?->satuan == 2){
                        $nilai = $this->hitungGajiDariPersen($value->kurang?->nilai);
                    }else{
                        $nilai = $value->kurang?->nilai;
                    }

                    $potongan[] = [
                        'kode_payroll' => $kodePayroll,
                        'nip' => $pegawai->nip,
                        'kode_kurang' => $value->kode_kurang,
                        'keterangan' => $value->kurang?->nama,
                        'nilai' => $nilai,
                    ];
                    $totalPotongan += (int)$nilai;
                }
            }
        }
        return [
            'data' => $potongan,
            'total' => $totalPotongan,
        ];
    }
    function calculatePresensi($pegawai){
        // $pegawai->load('jamKerja','shift');

        $totalAbsen = $this->rekapAbsen($pegawai,1,26,25); #telat dan cepat pulang
        // dd($totalAbsen);
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
            $jamKerja = $jamKerja?->jamKerja ?? $shift?->shift;
            $status = explode(",",$absen->status);
            // dd($status,$absen->id);
            if(in_array(2,$status)){
                $telat++;
                $telatMenit += hitungTelat($absen?->tanggal." ".$jamKerja?->jam_tepat_pulang,$absen?->tanggal_pulang,$jamKerja?->toleransi);
            }
            if(in_array(6,$status)){
                $pulangCepat++;
                $pulangCepatMenit += hitungCepatPulang($absen?->tanggal." ".$jamKerja?->jam_tepat_pulang,$absen?->tanggal_pulang);
                // dd($pulangCepatMenit);
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
    function hitungGajiDariPersen($persen){
        return $this->gajiPokok * $persen / 100;
    }

    #Function Support
    function getKeteranganTambahPayroll($keterangan,$daftarTambahPayroll){
        $kodeKeterangan = explode(",",$daftarTambahPayroll->kode_keterangan);
        // dd($kodeKeterangan);
        switch ($keterangan) {
            case '1': # Pegawai Tertentu
                return $kodeKeterangan;
            case '2': # Jabatan Terpilih
                return $this->pegawaiRepository->getPegawaiWhereJabatan($kodeKeterangan)->pluck('nip')->toArray();
            case '3': # Level Jabatan
                return $this->pegawaiRepository->getPegawaiWhereLevelJabatan($kodeKeterangan)->pluck('nip')->toArray();
            case '4': # Divisi Kerja
                return $this->pegawaiRepository->getPegawaiWhereDivisiKerja($kodeKeterangan)->pluck('nip')->toArray();
            default:
                # code...
                break;
        }
    }
    function getKeteranganKurangPayroll($keterangan,$daftarKurangPayroll){
        $kodeKeterangan = explode(",",$daftarKurangPayroll->kode_keterangan);
        // dd($kodeKeterangan);
        switch ($keterangan) {
            case '1': # Pegawai Tertentu
                return $kodeKeterangan;
            case '2': # Jabatan Terpilih
                return $this->pegawaiRepository->getPegawaiWhereJabatan($kodeKeterangan)->pluck('nip')->toArray();
            case '3': # Level Jabatan
                return $this->pegawaiRepository->getPegawaiWhereLevelJabatan($kodeKeterangan)->pluck('nip')->toArray();
            case '4': # Divisi Kerja
                return $this->pegawaiRepository->getPegawaiWhereDivisiKerja($kodeKeterangan)->pluck('nip')->toArray();
            default:
                # code...
                break;
        }
    }
}
