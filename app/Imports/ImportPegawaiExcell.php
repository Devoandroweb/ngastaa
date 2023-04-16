<?php

namespace App\Imports;

use App\Models\Presensi\TotalPresensi;
use App\Models\User;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ImportPegawaiExcell implements ToCollection, WithStartRow
{
    /**
    * @param Collection $collection
    */
    protected $errorMessage = null;
    protected $error = false;
    protected $errorRow = 0;
    protected $i = 0;
    public function collection(Collection $collection)
    {
        DB::beginTransaction();
        try {
            //code...
            $i = 2;
            $insertIntoTotalPresensi = [];

            foreach ($collection as $row ) {
                if($row[0] == null || $row[6] == ""){
                    continue;
                };
                // dd(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[6]));
                // array_push($data,$row);

                $item = new User();
                $item->nip = $row[1];
                $item->password = Hash::make($row[1]);
                $item->gelar_depan = $row[2];
                $item->gelar_belakang = $row[3];
                $item->name = $row[4];
                $item->tempat_lahir = $row[5];
                $item->tanggal_lahir = $this->checkTanggal($row[6],$i);
                $item->jenis_kelamin = $this->checkJenisKelamin(str_replace(" ","",strtolower($row[7])),$i);
                $item->kode_agama = $row[8];
                $item->kode_kawin = strtolower($row[9]);
                $item->golongan_darah = $row[10];
                $item->nik = $row[11];
                $item->no_hp = $row[12];
                $item->email = $row[13];
                $item->alamat = $row[14];
                $item->alamat_ktp = $row[15];
                $item->kode_status = $row[16]; // harus sesuai kode pada table status_pegawai
                $item->save();
                $item->assignRole('pegawai');
                $i++;
                
                array_push($insertIntoTotalPresensi,[
                    'nip' => $item->nip,
                    'periode_bulan' =>  date("Y-m")
                ]);
            }
            # Insert Into Total Presensi
            // dd($data);
            TotalPresensi::insert($insertIntoTotalPresensi);
            DB::commit();
        } catch (\Throwable $th) {
            
            DB::rollBack();
            
            
            $this->error = true;
            $this->errorMessage = $th->getMessage();
            //throw $th;
        }
    }
    public function startRow(): int
    {
        return 2;
    }
    function checkJenisKelamin($jenis_kelamin,$i){
        if($jenis_kelamin != "laki-laki" && $jenis_kelamin != "perempuan"){
            return throw new Exception("Kesalahan Jenis Kelamin ($jenis_kelamin), Jenis kelamin harus `laki-laki` atau `perempuan`, Kesalahan pada baris Excel ke $i");
        }
        return $jenis_kelamin;
    }
    function checkTanggal($row,$i){
        try {
            $tanggal = $this->transformDate($row);
            if($tanggal == "1970-01-01"){
                return throw new Exception($this->errorTanggal($i));
            }
            return $tanggal;
        } catch (\Throwable $th) {
            $this->error = true;
            $this->errorMessage = $this->errorTanggal($i);
            
            // $this->errorMessage = $th->getMessage();
        }
        
    }
    function errorMessage(){
        return $this->errorMessage;
    }
    function errorStatus(){
        return $this->error;
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
    public function transformDate($value, $format = 'Y-m-d')
    {
        try {
            return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value)->format('Y-m-d');
        } catch (\Throwable $e) {
            $value = str_replace("/","-",$value);
            return date('Y-m-d',strtotime($value));
        }
    }
}
