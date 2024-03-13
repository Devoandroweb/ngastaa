<?php

namespace App\Http\Controllers;

use App\Models\AppStatusFunction;
use App\Models\MapLokasiKerja;
use App\Models\Master\Lokasi;
use App\Models\MJadwalShift;
use App\Models\Payroll\DataPayroll;
use App\Models\Payroll\PayrollKurang;
use App\Models\Payroll\PayrollTambah;
use App\Models\Pegawai\DataPengajuanCuti;
use App\Models\Pegawai\DataPengajuanLembur;
use App\Models\Pegawai\DataPengajuanReimbursement;
use App\Models\Pegawai\DataPresensi;
use App\Models\Pegawai\DataVisit;
use App\Models\Pegawai\Imei;
use App\Models\Pegawai\Keluarga;
use App\Models\Pegawai\RiwayatBahasa;
use App\Models\Pegawai\RiwayatCuti;
use App\Models\Pegawai\RiwayatDiklat;
use App\Models\Pegawai\RiwayatGolongan;
use App\Models\Pegawai\RiwayatJabatan;
use App\Models\Pegawai\RiwayatJamKerja;
use App\Models\Pegawai\RiwayatKgb;
use App\Models\Pegawai\RiwayatKursus;
use App\Models\Pegawai\RiwayatLainnya;
use App\Models\Pegawai\RiwayatLhkpn;
use App\Models\Pegawai\RiwayatOrganisasi;
use App\Models\Pegawai\RiwayatPendidikan;
use App\Models\Pegawai\RiwayatPmk;
use App\Models\Pegawai\RiwayatPotongan;
use App\Models\Pegawai\RiwayatShift;
use App\Models\Pegawai\RiwayatSpt;
use App\Models\Pegawai\RiwayatStatus;
use App\Models\Pegawai\RiwayatTunjangan;
use App\Models\Presensi\TotalPresensiDetail;
use App\Repositories\Payroll\PayrollRepository;
use App\Repositories\TotalPresensi\TotalPresensiRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CCronjobs extends Controller
{
    protected $totalPresensiRepository;
    protected $payrollRepository;
    function __construct(
        TotalPresensiRepository $totalPresensiRepository,
        PayrollRepository $payrollRepository,
    )
    {
        $this->totalPresensiRepository = $totalPresensiRepository;
        $this->payrollRepository = $payrollRepository;
    }
    function calculatePresensi(){
        try {
            DB::transaction(function(){
                // $resultCalculate = $this->totalPresensiRepository->calculatePresensi();
                $resultCalculate = $this->totalPresensiRepository->manualCaculate();
                // dd($resultCalculate);
                if ($resultCalculate == 0) {
                    return response()->json([
                        'status' => FALSE,
                        'message' => 'Maaf Perhitungan Presensi untuk hari ini sebelumnya sudah di hitung'
                    ]);
                }
            });
            DB::commit();
            return response()->json([
                'status' => TRUE,
                'message' => 'Berhasil menghitung presensi untuk hari ini, silahkan klik link berikut untuk meninjau perhitungan, <br>
                <a href="'.route("presensi.total_presensi.index").'">Tinjau</a>'
            ]);

        } catch (\Throwable $th) {
            DB::rollBack();
            $fileError = fopen('error_cronjob.txt','a');
            fwrite($fileError, $th->getMessage() ." | file : ".$th->getFile()." | line : ".$th->getLine()." | ". now());
            fclose($fileError);

            return response()->json([
                'status' => FALSE,
                'message' => 'Gagal Menghitung Presensi untuk hari ini dengan Error : '.$th->getMessage()
            ]);
        }
    }
    function resetAppStatusCalculatePresensi(){

        try{
            $value = AppStatusFunction::where('name','calculate_presensi')->first();
            $value->value = 0;
            $value->update();
            return response()->json([
                'status' => TRUE,
                'message' => 'Reset Sukses'
            ]);
        } catch (\Throwable $th) {
            // return report($th->getMessage());
            return response()->json([
                'status' => FALSE,
                'message' => 'Reset Gagal dengan Error : '.$th->getMessage()
            ]);
        }

    }
    function calculatePayroll(){
        $this->payrollRepository->hitungPayroll();
    }
    function updateNip() {
        $nip = [
    '242',
    '137',
    '232',
    '168',
    '223',
    '224',
    '238',
    '222',
    '200',
    '259',
    '209',
    '226',
    '185',
    '239',
    '244',
    '269',
    '275',
    '253',
    '216',
    '252',
    '248',
    '265',
    '278',
    '294',
    '182',
    '255',
    '284',
    '256',
    '211',
    '199',
    '258',
    '257',
    '260',
    '189',
    '261',
    '263',
    '203',
    '237',
    '254',
    '162',
    '314',
    '290',
    '250',
    '308',
    '288',
    '282',
    '301',
    '274',
    '300',
    '188',
    '191',
    '204',
    '241',
    '210',
    '212',
    '215',
    '221',
    '230',
    '231',
    '266',
    '268',
    '272',
    '276',
    '277',
    '280',
    '283',
    '281',
    '286',
    '279',
    '285',
    '289',
    '291',
    '292',
    '293',
    '296',
    '298',
    '304',
    '305',
    '310',
    '302',
    '303',
    '306',
    '307',
    '309',
    '311',
    '312',
    '313',
    '316',
    '317',
    '319',
    '320',
    '323',
    '330',
    '321',
    '324',
    '325',
    '331',
    '332',
    '342',
    '295',
    '322',
    '326',
    '327',
    '328',
    '335',
    '337',
    '338',
    '339',
    '340',
    '341',
    '343'
    ];
    try {
        // $users = User::whereIn("nip",$nip)->get();
        // foreach($users as $user){
        //     $user->update([
        //         "nip" => "00".$user->nip
        //     ]);
        // }
        DB::transaction(function()use($nip){
            $models = [
                DataPayroll::class,
                DataPengajuanCuti::class,
                DataPengajuanLembur::class,
                DataPengajuanReimbursement::class,
                DataPresensi::class,
                DataVisit::class,
                Imei::class,
                MJadwalShift::class,
                Keluarga::class,
                MapLokasiKerja::class,
                PayrollKurang::class,
                PayrollTambah::class,
                RiwayatKgb::class,
                RiwayatPmk::class,
                RiwayatSpt::class,
                RiwayatCuti::class,
                RiwayatLhkpn::class,
                RiwayatShift::class,
                RiwayatBahasa::class,
                // RiwayatDiklat::class,
                RiwayatKursus::class,
                RiwayatStatus::class,
                RiwayatLhkpn::class,
                RiwayatJabatan::class,
                RiwayatLainnya::class,
                // RiwayatGolongan::class,
                RiwayatJamKerja::class,
                RiwayatPotongan::class,
                RiwayatTunjangan::class,
                RiwayatOrganisasi::class,
                RiwayatPendidikan::class,
                TotalPresensiDetail::class,
            ];
            foreach($models as $model){
                foreach($model::get() as $user){
                    $user->update([
                        "nip" => "00".$user->nip
                    ]);
                }
            }
        });
        # Data Payroll
        # data pengajuan cuti
        # data pengajuan lembur
        # data pengajuan reimvurs
        # data presensi
        # data visit
        # imei
        # jadwal shift
        # keluarga
        # manage lokasi kerja
        # payroll kurang
        # payroll tambah
        # semua riwayat
        # total presensi detail
        DB::commit();
    } catch (\Throwable $th) {
        DB::rollBack();
        dd($th->getMessage());
    }


    }
}
