<?php

namespace App\Exports;

use App\Models\Master\Skpd;
use App\Models\Master\Tingkat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ExportSampleImportPegawai implements WithMultipleSheets
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $kodeSkpd;
    function __construct($kodeSkpd){
        $this->kodeSkpd = $kodeSkpd;
    }
    public function sheets(): array
    {
        $jabatan = Tingkat::select("tingkat.nama as nama_tingkat","kode_tingkat", "skpd.nama", "skpd.kode_skpd")
                ->join('skpd','skpd.kode_skpd','=','tingkat.kode_skpd');
        if($this->kodeSkpd){
            $jabatan = $jabatan->where('tingkat.kode_skpd',$this->kodeSkpd);
        }
        $jabatan = $jabatan->orderBy('skpd.nama','asc')->get();
        $sizeRowJabatan = $jabatan->count();

        $divisi = Skpd::all();
        $sizeRowDivisi = $jabatan->count();

        $sheets = [];
        $sheets[] = new ExportMasterDivisiAndJabatan($jabatan);
        if($this->kodeSkpd == null){
            $sheets[] = new ExportMasterDivisi($divisi);
        }
        $sheets[] = new ExportTemplateImportPegawai($sizeRowJabatan,$sizeRowDivisi,$this->kodeSkpd);
        $sheets[] = new ExportTemplateProtection($this->kodeSkpd);

        return $sheets;
    }

}
