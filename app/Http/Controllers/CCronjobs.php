<?php

namespace App\Http\Controllers;

use App\Events\MyEvent;
use App\Events\PushAbsensi;
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
use App\Models\User;
use App\Repositories\CalculatePresensi\CalculatePresensiRepository;
use App\Repositories\Payroll\PayrollRepository;
use App\Repositories\TotalPresensi\TotalPresensiRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Pusher\Pusher;

class CCronjobs extends Controller
{
    protected $totalPresensiRepository;
    protected $calculatePresensiRepository;
    protected $payrollRepository;
    function __construct(
        TotalPresensiRepository $totalPresensiRepository,
        CalculatePresensiRepository $calculatePresensiRepository,
        PayrollRepository $payrollRepository,
    )
    {
        $this->totalPresensiRepository = $totalPresensiRepository;
        $this->calculatePresensiRepository = $calculatePresensiRepository;
        $this->payrollRepository = $payrollRepository;
    }
    function calculatePresensi(){
        try {
            DB::transaction(function(){
                $startCacl = date("Y-m-d H:i:s");
                $resultCalculate = app(CalculatePresensiRepository::class)->manualCalculate();
                // dd($resultCalculate[0]);
                foreach ($resultCalculate as $data) {
                    if($data["tanggal"]=="2024-05-27"){
                        // dd($data);
                        TotalPresensiDetail::create($data);
                    }
                }

                // if ($resultCalculate != 0) {
                //     $endCacl = date("Y-m-d H:i:s");
                //     $fileSuccess = fopen('sukses_cronjob.txt','a');
                //     fwrite($fileSuccess, "Run calculate absensi in : Start = ".$startCacl."| End = ".$endCacl);
                //     fclose($fileSuccess);
                // }
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
            'message' => 'Gagal Menghitung Presensi untuk hari ini dengan Error : '.$th->getMessage() ." | file : ".$th->getFile()." | line : ".$th->getLine()." | ". now()
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

    function cobaCronjob(){
        // dd(path("/"));
        require public_path("../vendor/autoload.php");

        $pusher = new Pusher(
            "7db08cceaf68e9dddedb",
            "68cd7feefe07b9473d82",
            "1808167",
            array('cluster' => 'ap1')
        );

        $pusher->trigger('my-channel', 'my-event', array('message' => 'hello world'));
        // event(new PushAbsensi(request('msg')));
    }
    function updateNip() {
        $data = [
            ["Wahyu Widayat" ,'70001'],
            ["Supriyanto",'70002'],
            ["Mahfud Alfandi",'70003'],
            ["Suyanto",'70004'],
            ["M Agus Septiyadi",'70005'],
            ["Benedictus Murdia suni",'70006'],
            ["Subarkah Hendro Hernowo",'60001'],
            ["Heri Suryono",'60002'],
            ["Sugiarto",'60003'],
            ["Nuranto Wahyu Widayanto",'60004'],
            ["Prasetyo Widhi",'60005'],
            ["Yanuar Rizky Albar",'60006'],
            ["Alditra Iqdam Albani",'60007'],
            ["Eko Hadi Saputro",'60008'],
            ["Dwi Tomo Respati Putranto",'50001'],
            ["Febrian Saputro",'50002'],
            ["Supraptono",'50003'],
            ["Imam Budi Baroroh",'50004'],
            ["Sugiyanto",'50005'],
            ["Surya Ariyanto",'50006'],
            ["Nunung Fauzi",'50007'],
            ["Sumiran",'50008'],
            ["Tirto Hadi Prabowo",'50009'],
            ["Sutikno",'50010'],
            ["J. Suradi",'50011']
        ];
    try {
        DB::transaction(function()use($data){

            foreach ($data as $v) {
                $user = User::whereName($v[0])->first();
                if($user){
                    // dd($user);
                    $user->update(["nip"=>$v[1]]);
                    $this->updateNipInRwt($user->nip,$v[1]);
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
    function updateNipInRwt($nip,$newNip){
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
            foreach($model::whereNip($nip)->get() as $user){
                $user->update([
                    "nip" => $newNip
                ]);
            }
        }
    }
    function resetPasswordAllUser(){
        try {
            foreach (User::where("owner",0)->get() as $user) {
                $this->resetPassword($user);
            }
            return response()->json(['status' => TRUE, 'message'=>'Password berhasil di reset, gunakan password NIP']);
        } catch (\Throwable $th) {
            return response()->json(['status' => FALSE, 'message'=>"Error Server"]);
            //throw $th;
        }
    }
    function resetPassword($user){
        $user->update([
            "password" => Hash::make($user->nip)
        ]);
    }
}
