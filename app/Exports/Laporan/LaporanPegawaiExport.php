<?php

namespace App\Exports\Laporan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanPegawaiExport implements FromView,ShouldAutoSize,WithStyles
{
    public $bulan;
    public $tahun;
    public $xl;
    public $pegawai;
    public $jamKerja;
    public function __construct($bulan, $tahun, $xl, $pegawai, $jamKerja) {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
        $this->pegawai = $pegawai;
        $this->xl = $xl;
        $this->jamKerja = $jamKerja;
    }

    public function view(): View
    {
        $bulan = $this->bulan;
        $tahun = $this->tahun;
        $pegawai = $this->pegawai;
        $xl = $this->xl;
        $jamKerja = $this->jamKerja;
        return view('laporan.presensi.pegawai-xls', compact('bulan', 'tahun', 'pegawai', 'xl','jamKerja'));
    }
    public function styles(Worksheet $sheet)
    {
        return $sheet->getStyle('A1:J44')->getFont()->setName("Times New Roman");
    }
}
