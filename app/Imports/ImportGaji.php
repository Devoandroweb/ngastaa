<?php

namespace App\Imports;

use App\Models\Master\Payroll\Pengurangan;
use App\Models\Master\Payroll\Potongan;
use App\Models\Master\Payroll\Tambahan;
use App\Models\Master\Payroll\Tunjangan;
use App\Models\Payroll\DataPayroll;
use App\Models\Payroll\GeneratePayroll;
use App\Models\Payroll\PayrollKurang;
use App\Models\Payroll\PayrollTambah;
use App\Repositories\Payroll\PayrollRepository;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ImportGaji implements ToCollection, WithEvents, WithCalculatedFormulas
{
    protected $listTunjangan = [];
    protected $listPotongan = [];
    protected $colGajiPokok = 4;
    protected $colTunjangan = 7;
    protected $colBonus = 0;
    protected $colPotongan = 0;
    protected $colTotalTunjangan = 0;
    protected $colTotalBonus = 0;
    protected $colTotalPenerimaan = 0;
    protected $colTotalPotongan = 0;
    protected $colTotalGaji = 0;
    protected $lastCol = 0;

    # Varibale For Database
    protected $listPayrollTambah = [];
    protected $listBonus = [];
    protected $listPayrollKurang = [];

    protected $tunjangan;
    protected $bonus;
    protected $potongan;

    protected $payrollRepository;
    /**
    * @param Collection $collection
    */
    function __construct(PayrollRepository $payrollRepository){
        $this->tunjangan = Tunjangan::all();
        $this->potongan = Pengurangan::all();
        $this->bonus = Tambahan::all();

        $this->payrollRepository = $payrollRepository;
        // $this->payrollRepository->calculatePresensi();
    }
    public function collection(Collection $collection)
    {
        try {
            DB::transaction(function() use ($collection) {

                # Buat List Tunjangan ----------------------------------------------------
                $this->checkExistingTunjangan($collection[1][$this->colTunjangan]);
                for ($i=$this->colTunjangan; $i < count($collection[1]); $i++) {
                    if($collection[1][$i]){
                        array_push($this->listTunjangan,$collection[1][$i]);
                    }else{
                        break;
                    }
                }
                # ------------------------------------------------------------------------
                # Buat List Bonus --------------------------------------------------------
                $this->colBonus = count($this->listTunjangan)+8;
                $this->checkExistingBonus($collection[1][$this->colBonus]);
                for ($i=$this->colBonus; $i < count($collection[1]); $i++) {
                    if($collection[1][$i]){
                        array_push($this->listBonus,$collection[1][$i]);
                    }else{
                        break;
                    }
                }
                # ------------------------------------------------------------------------
                # Buat List Potongan -----------------------------------------------------
                $this->colPotongan = count($this->listTunjangan)+8+count($this->listBonus)+2;
                $this->checkExistingPotongan($collection[1][$this->colPotongan]);
                for ($i=$this->colPotongan; $i < count($collection[1]); $i++) {
                    if($collection[1][$i]){
                        array_push($this->listPotongan,$collection[1][$i]);
                    }else{
                        break;
                    }
                }
                // dd($this->listPotongan);
                # ------------------------------------------------------------------------
                # Configuration Col-------------------------------------------------------
                $this->colTotalTunjangan = $this->colTunjangan+count($this->listTunjangan);
                $this->colTotalBonus = $this->colTotalTunjangan+count($this->listBonus)+1;
                $this->colTotalPenerimaan = $this->colTotalBonus+1;
                // dd($collection[2],$collection[2][$this->colTotalPenerimaan],$this->colTotalPenerimaan);
                $this->colTotalPotongan = $this->lastCol-2;
                $this->colTotalGaji = $this->lastCol-1;
                # -------------------------------------------------------------------------
                $kodePayroll = date("YmdHis") . generateRandomString();
                $dataSaveForPayrollTambah = [];
                $dataSaveForPayrollKurang = [];
                $dataSaveForDataPayroll = [];
                foreach ($collection as $i => $row) {
                    if($i == 0 || $i == 1){
                        continue;
                    }
                    $nip = $row[1];

                    # Payroll Tambah ---------------------------------------------------
                    $k = 0;
                    for ($j=$this->colTunjangan; $j < $this->colTotalTunjangan; $j++) {
                        if(!in_array($row[$j],[null,0])){
                            $kodeTunjangan = $this->searchKodeTunjangan($this->listTunjangan[$k]);
                            $nominalTunjangan = $row[$j];
                            $this->listPayrollTambah[] = [
                                'nip' => $nip,
                                'kode_payroll' => $kodePayroll,
                                'kode_tambahan' => $kodeTunjangan,
                                'keterangan' => $this->listTunjangan[$k],
                                'nilai' => $nominalTunjangan,
                            ];
                            $k++;
                        }
                    }
                    # ------------------------------------------------------------------
                    # Payroll Tambah (Bonus) ---------------------------------------------------
                    // dd($this->listBonus);
                    $m = 0;
                    for ($n=$this->colBonus; $n < $this->colTotalBonus; $n++) {
                        if(!in_array($row[$n],[null,0])){
                            $kodeBonus = $this->searchKodeBonus($this->listBonus[$m]);
                            $nominalBonus = $row[$n];
                            $this->listPayrollTambah[] = [
                                'nip' => $nip,
                                'kode_payroll' => $kodePayroll,
                                'kode_tambahan' => $kodeBonus,
                                'keterangan' => $this->listBonus[$m],
                                'nilai' => $nominalBonus,
                            ];
                            $m++;
                        }
                    }
                    if(count($this->listPayrollTambah) != 0){
                        $dataSaveForPayrollTambah[] = $this->listPayrollTambah;
                    }
                    $this->listPayrollTambah = [];
                    // dd($dataSaveForPayrollTambah);
                    # ------------------------------------------------------------------
                    # Payroll Kurang ---------------------------------------------------
                    $l = 0;
                    for ($m=$this->colPotongan; $m < $this->colTotalPotongan; $m++) {
                        if(!in_array($row[$m],[null,0])){
                            $kodePotongan = $this->searchKodePotongan($this->listPotongan[$l]);
                            $nominalPotongan = $row[$m];
                            $this->listPayrollKurang[] = [
                                'nip' => $nip,
                                'kode_payroll' => $kodePayroll,
                                'kode_kurang' => $kodePotongan,
                                'keterangan' => $this->listPotongan[$l],
                                'nilai' => $nominalPotongan,
                            ];
                            $l++;
                        }
                    }
                    if(count($this->listPayrollKurang) != 0){
                        $dataSaveForPayrollKurang[] = $this->listPayrollKurang;
                    }
                    $this->listPayrollKurang = [];
                    # ------------------------------------------------------------------
                    # Total Total ------------------------------------------------------
                    $totalTunjangan = $row[$this->colTotalTunjangan];
                    $totalPenerimaan = $row[$this->colTotalPenerimaan];
                    $totalPotongan = $row[$this->colTotalPotongan];
                    $totalGaji = $row[$this->colTotalGaji];
                    # ------------------------------------------------------------------
                    # Configuration Save To Data_Payroll -------------------------------
                    $bulan = date("m"); # Bulan
                    $tahun = date("Y"); # Tahun
                    $kodeTingkat = $row[4];
                    $jabatan = $row[5];
                    $divisi = $row[3];
                    $gajiPokok = $row[6];
                    if($totalGaji != 0){
                        $dataSaveForDataPayroll[] = [
                            'kode_payroll' => $kodePayroll,
                            'bulan' => $bulan,
                            'tahun' => $tahun,
                            'nip' => $nip,
                            'kode_tingkat'=>$kodeTingkat,
                            'jabatan'=>$jabatan,
                            'divisi'=>$divisi,
                            'gaji_pokok'=>$gajiPokok,
                            'tunjangan'=>$totalTunjangan,
                            'total_penambahan'=>$totalPenerimaan,
                            'total_potongan'=>$totalPotongan,
                            'total'=>$totalGaji,
                        ];
                    }
                }
                # Insert Into Payroll Tambah ----------------------------------------------
                if(count($dataSaveForPayrollTambah) != 0){
                    foreach ($dataSaveForPayrollTambah as $value) {
                        PayrollTambah::insert($value);
                    }
                }
                # -------------------------------------------------------------------------
                # Insert Into Payroll Kurang
                if(count($dataSaveForPayrollKurang) != 0){
                    foreach ($dataSaveForPayrollKurang as $value) {
                        PayrollKurang::insert($value);
                    }
                }
                # -------------------------------------------------------------------------
                #Insert Into Data Payroll -------------------------------------------------
                DataPayroll::insert($dataSaveForDataPayroll);
                $this->payrollRepository->insertWithDivisi($kodePayroll);
                # -------------------------------------------------------------------------
            });
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
            //throw $th;

        }
    }
    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function(BeforeSheet $event) {
                $sheet = $event->sheet;
                // dd(excelColumnToNumber($sheet->getHighestColumn()));
                $this->lastCol = excelColumnToNumber($sheet->getHighestColumn());

            },
        ];
    }
    function startRow(){
        return 2;
    }
    #Message Handle
    function checkExistingTunjangan($tunjangan){
        if(!$tunjangan){
            return throw new Exception($this->errorMessageTunjangan());
        }
    }
    function checkExistingBonus($bonus){
        if(!$bonus){
            return throw new Exception($this->errorMessageBonus());
        }
    }
    function checkExistingPotongan($potongan){
        if(!$potongan){
            return throw new Exception($this->errorMessagePotongan()." | $potongan");
        }
    }
    function errorMessageTunjangan(){
        return "Tunjangan Tidak tersedia dalam Master";
    }
    function errorMessageBonus(){
        return "Bonus/Tambahan Tidak tersedia dalam Master";
    }
    function errorMessagePotongan(){
        return "Potongan Tidak tersedia dalam Master";
    }

    #Searing Data
    function searchKodeTunjangan($namaTunjangan){
        foreach ($this->tunjangan as $value) {
            if($namaTunjangan == $value->nama){
                return $value->kode_tunjangan;
            }
        }
        return null;
    }
    function searchKodePotongan($namaPotongan){
        foreach ($this->potongan as $value) {
            if($namaPotongan == $value->nama){
                return $value->kode_kurang;
            }
        }
        return null;
    }
    function searchKodeBonus($namaBonus){
        foreach ($this->bonus as $value) {
            if($namaBonus == $value->nama){
                return $value->kode_tambah;
            }
        }
        return null;
    }
}
