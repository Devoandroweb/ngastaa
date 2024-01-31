<?php

namespace App\Imports;

use App\Models\Master\Skpd;
use App\Models\Master\StatusPegawai;
use App\Models\Master\Tingkat;
use App\Models\Pegawai\RiwayatJabatan;
use App\Models\Presensi\TotalPresensi;
use App\Models\User;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ImportPegawaiExcell implements ToCollection, WithStartRow,WithMultipleSheets
{
    /**
    * @param Collection $collection
    */
    protected $errorMessage = null;
    protected $statusError = false;
    protected $errorRow = 0;
    protected $kodeSkpd = 0;
    protected $kodeTingkat = 0;
    protected $statusPegawai;
    protected $tingkat;
    protected $skpd;
    protected $sheet;
    protected $i = 0;
    function __construct(
        $kodeSkpd,
        $kodeTingkat,
        $sheet,
    ) {
        $this->kodeSkpd = $kodeSkpd;
        if(role('admin') || role('owner')){
            $this->kodeTingkat = $kodeTingkat;
        }
        $this->statusPegawai = StatusPegawai::all();
        $this->tingkat = Tingkat::all();
        $this->skpd = Skpd::with('tingkatMany')->get();
        $this->sheet = $sheet;
    }
    public function sheets() : array
    {
        return [
            $this->sheet => $this
        ];
    }
    public function collection(Collection $collection)
    {

        try {
            DB::beginTransaction();
            DB::transaction(function()use($collection){
                $no = 0;
                $i = 2;
                $insertIntoTotalPresensi = [];
                // dd($this->sheet);
                foreach ($collection as $iter => $row ) {
                    echo $row[0];
                    if($row[0] == null){
                        continue;
                    };

                    // dd(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[6]));
                    // array_push($data,$row);

                    $this->nipExisting($row[1]);
                    // dd($iter,$row[4]);
                    $nip = $this->checkNip($row[1],$i);
                    $item = new User();
                    $item->nip = $nip;
                    $item->password = Hash::make($nip);
                    $item->gelar_depan = $row[2];
                    $item->gelar_belakang = $row[3];
                    $item->name = $row[4];
                    $item->tempat_lahir = $row[5];
                    $item->tanggal_lahir = $this->checkTanggal($row[6],$i);
                    $item->jenis_kelamin = $row[7];
                    $item->kode_agama = $row[8];
                    $item->kode_kawin = $row[9];
                    $item->golongan_darah = $row[10];
                    $item->nik = $row[11];
                    $item->no_hp = $row[12];
                    $item->email = $row[13];
                    $item->alamat = $row[14];
                    $item->alamat_ktp = $row[15];
                    $item->kode_status = $this->checkStatusPegawai($row[16],$i); // harus sesuai kode pada table status_pegawai
                    $item->save();
                    $item->assignRole('pegawai');
                    $i++;

                    array_push($insertIntoTotalPresensi,[
                        'nip' => $nip,
                        'periode_bulan' =>  date("Y-m")
                    ]);
                    $no++;
                    // $riwayatJabatan = RiwayatJabatan::where('nip', $nip);
                    // if($riwayatJabatan->first()){
                    //     $riwayatJabatan->update(['is_akhir' => 0]);
                    // }
                    if(role('admin') || role('owner')){
                        # Save to Riwayat Divisi
                        if($this->kodeSkpd){
                            RiwayatJabatan::create([
                                'nip' => $nip,
                                'kode_skpd' => $this->kodeSkpd,
                                'kode_tingkat' => $this->searchData2($this->tingkat,"nama",$row[17],"kode_tingkat"),
                                'jenis_jabatan' => 1,
                                'is_akhir' => 1
                            ]);
                        }else{
                            RiwayatJabatan::create([
                                'nip' => $nip,
                                'kode_skpd' => $this->searchData2($this->skpd,"nama",$row[17],"kode_skpd"),
                                'kode_tingkat' => $this->searchData2($this->tingkat,"nama",$row[18],"kode_tingkat"),
                                'jenis_jabatan' => 1,
                                'is_akhir' => 1
                            ]);
                        }
                    }
                    // else{
                    //     RiwayatJabatan::create([
                    //         'nip' => $nip,
                    //         'kode_skpd' => $this->kodeSkpd,
                    //         'kode_tingkat' => $this->checkExistingJabatanPegawai($this->kodeSkpd),
                    //         'jenis_jabatan' => 1,
                    //         'is_akhir' => 1
                    //     ]);
                    // }

                }
                # Insert Into Total Presensi
                TotalPresensi::insert($insertIntoTotalPresensi);
            });
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->statusError = true;
            $this->errorMessage = $th->getMessage()."|".$th->getLine()."|".$th->getFile();

            //throw $th;
        }
    }
    public function startRow(): int
    {
        return 2;
    }
    function checkNip($value,$i){
        if($value == "" || $value == null){

            return throw new Exception("NIP tidak boleh kosong, Kesalahan pada baris Excel ke $i");
        }
        return $value;
    }
    function nipExisting($nip){

        if(User::where('nip',$nip)->first() != null){

            return throw new Exception($this->alertMessageNip($nip));
        }
        return $nip;

    }
    function checkJenisKelamin($jenis_kelamin,$i){
        $jenis_kelamin = strtolower($jenis_kelamin);
        if($jenis_kelamin == "laki laki"){
            $jenis_kelamin = "laki-laki";
        }
        $jenis_kelamin = str_replace(" ","",$jenis_kelamin);
        if($jenis_kelamin != "laki-laki" && $jenis_kelamin != "perempuan"){
            return throw new Exception("Kesalahan Jenis Kelamin ($jenis_kelamin), Jenis kelamin harus `Laki-Laki` atau `Perempuan` tanpa spasi, Kesalahan pada baris Excel ke $i");
        }
        return $jenis_kelamin;
    }
    function checkGolonganDarah($row,$i){
        try {
            //code...
            $golRah = ['A','O','AB','B'];
            // dd($row);
            if(!in_array(strtoupper($row),$golRah)){
                return throw new Exception($this->errorGolonganDarah($row,$i));
            }
            return $row;
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->statusError = true;
            $this->errorMessage = $this->errorGolonganDarah($row,$i);
        }
    }
    function checkTanggal($row,$i){
        try {
            $tanggal = $this->transformDate($row);
            // dd($tanggal);
            if($tanggal == "1970-01-01"){
                return throw new Exception($this->errorTanggal($i));
            }
            return $tanggal;
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->statusError = true;
            $this->errorMessage = $this->errorTanggal($i);
            // $this->errorMessage = $th->getMessage();
        }

    }
    function checkKawin($row,$i){
        try {

            if(strtolower($row) == "menikah" || strtolower($row) == "belum menikah"){
                return throw new Exception($this->errorKawin($i));
            }
            return $row;
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->statusError = true;
            $this->errorMessage = $this->errorKawin($i);
            // $this->errorMessage = $th->getMessage();
        }

    }
    function checkStatusPegawai($row,$i){
        try {

            $statusPegawai = $this->searchData($this->statusPegawai,'nama',$row);

            if($i==111){
            }
            if(is_null($statusPegawai)){
                return throw new Exception($this->errorStatusPegawai($i,$row));
            }
            return $statusPegawai;
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->statusError = true;
            $this->errorMessage = $this->errorStatusPegawai($i,$row);

            // $this->errorMessage = $th->getMessage();
        }
    }
    function checkDivisiAndJabatan($divisi,$jabatan,$i){
        try {
            $result = [
                'kode_skpd' => null,
                'kode_tingkat' => null,
            ];
            $resultStatus = false;
            foreach ($this->skpd as $skpd) {
                if(strtolower($divisi) == strtolower($skpd->nama)){
                    foreach ($skpd->tingkatMany as $tingkat) {
                        if(strtolower($jabatan) == $tingkat->nama){
                            $result['kode_skpd'] = $skpd->kode_skpd;
                            $result['kode_tingkat'] = $tingkat->kode_tingkat;
                            $resultStatus = true;
                        }
                    }
                }
            }
            if($resultStatus){
                return $result;
            }
        }catch (\Throwable $th) {
            DB::rollBack();
            $this->statusError = true;
            $this->errorMessage = $this->errorDivisiAndJabatan($i);
            // $this->errorMessage = $th->getMessage();
        }
    }
    function checkExistingJabatanPegawai($kodeSkpd){
        // dd($kodeSkpd);
        $tingkat = Tingkat::where('kode_eselon',6)->where('kode_skpd',$kodeSkpd)->first();
        // dd($tingkat,$kodeSkpd);
        if(!$tingkat){
            return throw new Exception("Jabatan 'Pegawai' tidak ada, Hubungi Administrator");
        }
        return $tingkat->kode_tingkat;
    }
    function alertMessageNip($nip){
        return "NIP ($nip) Sudah di gunakan ";
    }
    function errorMessage(){
        return $this->errorMessage;
    }
    function errorStatus(){
        return $this->statusError;
    }
    function errorRow(){
        return $this->errorRow;
    }
    private function errorTanggal($i){
        $message = "Kesalahan Tanggal Lahir, pastikan tanggal sudah valid , Kesalahan pada baris Excel ke $i";
                $message .= "<br> Berikut contoh tanggal yang valid : <br> ";
                $message .= "
                            - 25/05/2023 <br>
                            - 25-05-2023
                            ";
        return $message;
    }
    private function errorGolonganDarah($value_darah,$i){
        $message = "Kesalahan Golongan Darah ($value_darah), pastikan golongan darah sudah valid tidak boleh menggunakan angka , Kesalahan pada baris Excel ke $i";
                $message .= "<br> Hanya gologan darah berikut yang valid : <br> ";
                $message .= "
                            - O <br>
                            - A <br>
                            - AB
                            ";
        return $message;
    }
    private function errorKawin($i){
        $message = "Kode Menikah salah, gunakan kata 'Menikah' atau 'Belum Menikah', Kesalahan pada baris Excel ke $i";
        return $message;
    }
    private function errorStatusPegawai($i,$row){
        $message = "Status Pegawai salah ($row), Kesalahan pada baris Excel ke ".$i-1;
        return $message;
    }
    private function errorDivisiAndJabatan($i){
        $message = "Divisi dan Jabatan salah, Kesalahan pada baris Excel ke $i";
        return $message;
    }
    public function transformDate($value, $format = 'Y-m-d')
    {
        $value = str_replace(" ","",$value);
        try {
            // dd($value);
            return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value)->format('Y-m-d');
        } catch (\Throwable $e) {
            $value = str_replace("/","-",$value);
            return date('Y-m-d',strtotime($value));
        }
    }
    function searchData($data,$column,$comparison){
        // dd($data->get(),"asdasd");
        // dd("asdasd",);
        foreach($data as $value){
            if(strtolower($value->{$column}) == strtolower($comparison)){
                return $value->{$column};
            }
        }
        return null;
    }
    function searchData2($data,$column,$comparison,$columnResult){
        // dd($data->get(),"asdasd");
        // dd("asdasd",);
        foreach($data as $value){
            if(strtolower($value->{$column}) == strtolower($comparison)){
                return $value->{$columnResult};
            }
        }
        return null;
    }

}
