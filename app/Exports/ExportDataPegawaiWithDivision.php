<?php

namespace App\Exports;

use App\Models\Master\Skpd;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ExportDataPegawaiWithDivision implements WithMultipleSheets
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $pegawaiRepository;
    function __construct($pegawaiRepository){
        $this->pegawaiRepository = $pegawaiRepository;
        // dd($this->pegawais);
    }
    public function sheets(): array
    {
        $skpd = Skpd::orderBy('nama')->get();
        foreach ($skpd as $key => $value) {
            # code...
            $sheets[] = new ExportDataPegawai($this->pegawaiRepository,$value->kode_skpd,$value->nama);
        }
        return $sheets;
    }
}
