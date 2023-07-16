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
    /**
    * @param Collection $collection
    */
    function sheets() : array {
        return [
            2 => $this
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
        } catch (\Throwable $th) {
            $this->message = $th->getMessage();
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
    
}
