<?php

namespace App\Imports;

use App\Models\AppStatusFunction;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ImportTemplateProtection implements ToCollection, WithMultipleSheets
{
    protected $errorStatus = false;
    protected $message;
    protected $numberSheet;
    /**
    * @param Collection $collection
    */
    protected $kodeSkpd;
    function __construct($kodeSkpd){
        $this->kodeSkpd = $kodeSkpd;
    }
    function sheets() : array {
        return [
            "Security" => $this
        ];
    }
    public function collection(Collection $collection)
    {
        try {
            //code...
            $oldCode = AppStatusFunction::whereName('excel_template_pegawai_version')->first()?->value;
            // dd($oldCode,$collection[0][0]);
            if($oldCode != $collection[0][0]){
                $this->errorStatus = true;
                $this->message = "Template Kadaluarsa, Silahkan Unduh ulang";
            }
            // dd($this->kodeSkpd != null && $collection[0][1] == "0",$this->kodeSkpd,$collection[0][1]);
            if($this->kodeSkpd != null && $collection[0][1] == "0"){
                $this->errorStatus = true;
                $this->message = "File tidak sesuai, File ini untuk Import Data Pegawai yang tidak berdasarkan divisi";
            }elseif($this->kodeSkpd != $collection[0][1]){
                $this->errorStatus = true;
                $this->message = "Divisi tidak sesuai, pilih Divisi pada dropdown di atas";
            }else{
                // dd($collection[0][1]);
                if($collection[0][1] == "0"){
                    $this->numberSheet = 2;
                }else{
                    $this->numberSheet = 1;
                }
            }
        } catch (\Throwable $th) {
            $this->message = $th->getMessage()."|".$th->getLine()."|".$th->getFile();
            $this->errorStatus = true;
            //throw $th;
        }
    }
    function errorStatus() : Bool{
        return $this->errorStatus;
    }
    function message() : String {
        return $this->message;
    }
    function getNumberSheet():Int{
        return $this->numberSheet;
    }

}
