<?php

namespace App\Exports;

use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportDataPegawai implements FromArray,WithHeadings,WithStyles,ShouldAutoSize,WithColumnFormatting,WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $pegawais;
    protected $pegawaiRepository;
    function __construct($pegawaiRepository){
        $this->pegawais = $pegawaiRepository->allPegawaiWithRole()->get();
        // dd($this->pegawais);
    }
    public function array() : Array
    {
        $result = [];
        foreach ($this->pegawais as $key => $pegawai) {
            $result[] = [
                $key+1,
                $pegawai->nip,
                $pegawai->gelar_depan,
                $pegawai->nama,
                $pegawai->gelar_belakang,
                $pegawai->tempat_lahir,
                tanggal_indo($pegawai->tanggal_lahir),
                Str::title($pegawai->jenis_kelamin),
                $pegawai->kode_agama,
                $pegawai->kode_kawin,
                $pegawai->golongan_darah,
                $pegawai->no_ktp,
                $pegawai->no_hp,
                $pegawai->email,
                $pegawai->alamat,
                $pegawai->alamat_ktp,
                $pegawai->statusPegawai?->nama ?? "-",

            ];
        }
        return $result;
    }
    public function headings(): array
    {
        return [
            "No",
            "NIP",
            "Gelar Depan",
            "Nama",
            "Gelar Belakang",
            "Tempat Lahir",
            "Tanggal Lahir",
            "Jenis Kelamin",
            "Agama",
            "Status Perkawinan",
            "Golongan Darah",
            "Nomor KTP",
            "NO. HP",
            "Email",
            "Alamat Domisili",
            "Alamat KTP",
            "Status",
        ];
    }
    public function styles(Worksheet $sheet)
    {

        // styling first row
        // $sheet->getStyle(1)->getFont()->setBold(true);
        $sheet->getParent()->getActiveSheet()->getStyle('M')->getAlignment()->setVertical("middle");
        $sheet->getParent()->getActiveSheet()->getStyle('M')->getAlignment()->setHorizontal("left");
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
            "M"    => ['alignment' => ['alignLeft' => true]],
        ];
    }
    public function columnFormats(): array
    {
        return [
            'M' => NumberFormat::FORMAT_NUMBER,
        ];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                    $workSheet = $event->sheet->getDelegate();
                    $workSheet->freezePane('C2');
                }
            ];
    }
}
