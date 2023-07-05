<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ExportSampleImportPegawai implements WithMultipleSheets
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function sheets(): array
    {
        $sheets = [];

        $sheets[] = new ExportTemplateImportPegawai();
        $sheets[] = new ExportMasterDivisiAndJabatan();

        return $sheets;
    }
    
}
