<?php

namespace App\Exports;

use App\Models\Master\Skpd;
use App\Models\Master\StatusPegawai;
use App\Models\Master\Tingkat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Protection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportTemplateImportPegawai implements FromCollection, WithHeadings, WithEvents, ShouldAutoSize, WithStyles, WithTitle, WithStartRow, WithColumnFormatting
{

    protected  $selects;
    protected  $row_count;
    protected  $column_count;

    public function __construct()
    {
        $jenisKelamin = ['Laki-Laki','Perempuan'];
        $agama = ['Islam', 'Kristen', 'Hindu', 'Budha', 'Kongucu', 'Katholik', 'Protestan'];
        $statusKawin = ['Menikah','Belum Menikah','Cerai Hidup','Cerai Mati'];
        $golDarah = ['A','B','AB','O'];
        $statusPegawai = StatusPegawai::orderBy('nama')->pluck('nama')->toArray();
        $divisi = Skpd::orderBy('nama')->get(['kode_skpd','nama']);
        $jabatan = Tingkat::orderBy('nama')->get(['kode_tingkat','nama']);

        // dd($divisi);
        $optionDivisi = [];
        foreach ($divisi as $value) {
            $optionDivisi[] = truncateText($value->kode_skpd." | ".$value->nama,15);
        }

        $optionJabatan = [];
        foreach ($jabatan as $value) {
            if(!in_array($value->nama,$optionJabatan)){
                $optionJabatan[] = truncateText($value->kode_tingkat." | ".$value->nama,15);
            }
        }
        // dd($optionDivisi);
        //$departments=ModelName::pluck('name')->toArray(); You can get values from a model or DB Facade
        $selects=[  //selects should have column_name and options
            ['columns_name'=>'H','options'=>$jenisKelamin], //Column H has heading departments. See headings() method below
            ['columns_name'=>'I','options'=>$agama],
            ['columns_name'=>'J','options'=>$statusKawin],
            ['columns_name'=>'K','options'=>$golDarah],
            ['columns_name'=>'Q','options'=>$statusPegawai],
            ['columns_name'=>'R','options'=>$optionDivisi],
            ['columns_name'=>'S','options'=>$optionJabatan],
        ];
        // dd($selects);
        $this->selects=$selects;
        $this->row_count=1000;//number of rows that will have the dropdown
        $this->column_count=19;//number of columns to be auto sized
    }
    public function collection()
    {
        return collect([
            ["1",
            "28",
            "Drs.",
            "S.kom",
            "Harun Ar-rosyid",
            "Semarang",
            "17 Agustus 1945",
            "Laki-Laki",
            "Islam",
            "Menikah",
            "O",
            "123456789",
            "6281809988812",
            "arrosyid@gmail.com",
            "Jl. Sukadana No. A2 Semarang, Kota Semarang",
            "Jl. Sukadana No. A2 Semarang, Kota Semarang",
            "Kontrak",
            "Head Office PT Deta Sukses Makmur",
            "Finance"]
        ]);
    }
    function startRow() : Int {
        return 2;
    }

    public function headings(): array
    {
        return [
            "No",
            "NIP",
            "Gelar Depan",
            "Gelar Belakang",
            "Nama",
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
            "Divisi",
            "Jabatan"
        ];
    }
    public function columnFormats(): array
    {
        return [
            'M' => NumberFormat::FORMAT_NUMBER,
        ];
    }
    public function styles(Worksheet $sheet)
    {
        $lastColumn = $sheet->getHighestColumn();

        // Make sure you enable worksheet protection if you need any of the worksheet or cell protection features!
        $sheet->getParent()->getActiveSheet()->getProtection()->setSheet(true);

        // lock all cells then unlock the cell
        $sheet->getParent()->getActiveSheet()
            ->getStyle('A2:S4000')
            ->getProtection()
            ->setLocked(Protection::PROTECTION_UNPROTECTED);

        $sheet->getParent()->getActiveSheet()->getStyle('B')->getAlignment()->setVertical("middle");
        $sheet->getParent()->getActiveSheet()->getStyle('B')->getAlignment()->setHorizontal("left");
        $sheet->getParent()->getActiveSheet()->getStyle('M')->getAlignment()->setVertical("middle");
        $sheet->getParent()->getActiveSheet()->getStyle('M')->getAlignment()->setHorizontal("left");

        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }

    public function registerEvents(): array
    {
        return [
            // handle by a closure.
            AfterSheet::class => function(AfterSheet $event) {

                $row_count = $this->row_count;
                $column_count = $this->column_count;
                foreach ($this->selects as $select) {
                    $drop_column = $select['columns_name'];
                    $options = $select['options'];

                    // Set dropdown list for first data row
                    $validation = $event->sheet->getCell("{$drop_column}2")->getDataValidation();
                    $validation->setType(DataValidation::TYPE_LIST);
                    $validation->setErrorStyle(DataValidation::STYLE_STOP);
                    $validation->setAllowBlank(false);
                    $validation->setShowInputMessage(true);
                    $validation->setShowErrorMessage(true);
                    $validation->setShowDropDown(true);
                    $validation->setErrorTitle('Input error');
                    $validation->setError('Nilai tidak ada dalam list.');
                    $validation->setPromptTitle('Gunakan nilai pada list');
                    $validation->setPrompt('Mohon Gunakan nilai pada drop-down list.');
                    $validation->setFormula1(sprintf('"%s"', implode(',', $options)));

                    // Clone validation to remaining rows
                    for ($i = 3; $i <= $row_count; $i++) {
                        $cell = $event->sheet->getCell("{$drop_column}{$i}");
                        $cell->setDataValidation(clone $validation);

                        // Add data validation error alert
                        $cell->getStyle()->getFont()->setBold(true);
                        $cell->getStyle()->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED));
                        $cell->getStyle()->getFont()->setSize(12);
                    }

                    // Set columns to autosize
                    for ($i = 1; $i <= $column_count; $i++) {
                        $column = Coordinate::stringFromColumnIndex($i);
                        $event->sheet->getColumnDimension($column)->setAutoSize(true);
                    }
                }

            },
        ];
    }
    public function title(): string
    {
        return 'Template';
    }
}
