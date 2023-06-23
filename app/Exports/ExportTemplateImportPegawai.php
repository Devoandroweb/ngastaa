<?php

namespace App\Exports;

use App\Models\Master\Skpd;
use App\Models\Master\StatusPegawai;
use App\Models\Master\Tingkat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportTemplateImportPegawai implements FromCollection, WithHeadings, WithEvents, ShouldAutoSize,WithStyles
{

    protected  $selects;
    protected  $row_count;
    protected  $column_count;

    public function __construct()
    {
        $jenisKelamin = ['Laki-Laki','Perempuan'];
        $agama = ['Islam', 'Kristen', 'Hindu', 'Budha', 'Kongucu', 'Katholik', 'Protestan'];
        $statusKawin = ['Menikah','Belum Menikah'];
        $golDarah = ['A','B','AB','O'];
        $statusPegawai = StatusPegawai::orderBy('nama')->pluck('nama')->toArray();
        $divisi = Skpd::orderBy('nama')->pluck('nama')->toArray();
        $jabatan = Tingkat::orderBy('nama')->pluck('nama')->toArray();

        //$departments=ModelName::pluck('name')->toArray(); You can get values from a model or DB Facade
        $selects=[  //selects should have column_name and options
            ['columns_name'=>'H','options'=>$jenisKelamin], //Column H has heading departments. See headings() method below
            ['columns_name'=>'I','options'=>$agama],
            ['columns_name'=>'J','options'=>$statusKawin],
            ['columns_name'=>'K','options'=>$golDarah],
            ['columns_name'=>'Q','options'=>$statusPegawai],
            ['columns_name'=>'R','options'=>$divisi],
            ['columns_name'=>'S','options'=>$jabatan],
        ];

        $this->selects=$selects;
        $this->row_count=50;//number of rows that will have the dropdown
        $this->column_count=5;//number of columns to be auto sized
    }
    public function collection()
    {
        return collect([]);
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

    public function styles(Worksheet $sheet)
    {

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
                foreach ($this->selects as $select){
                    $drop_column = $select['columns_name'];
                    $options = $select['options'];
                    // set dropdown list for first data row
                    $validation = $event->sheet->getCell("{$drop_column}2")->getDataValidation();
                    $validation->setType(DataValidation::TYPE_LIST );
                    $validation->setErrorStyle(DataValidation::STYLE_INFORMATION );
                    $validation->setAllowBlank(false);
                    $validation->setShowInputMessage(true);
                    $validation->setShowErrorMessage(true);
                    $validation->setShowDropDown(true);
                    $validation->setErrorTitle('Input error');
                    $validation->setError('Value is not in list.');
                    $validation->setPromptTitle('Pick from list');
                    $validation->setPrompt('Please pick a value from the drop-down list.');
                    $validation->setFormula1(sprintf('"%s"',implode(',',$options)));

                    // clone validation to remaining rows
                    for ($i = 3; $i <= $row_count; $i++) {
                        $event->sheet->getCell("{$drop_column}{$i}")->setDataValidation(clone $validation);
                    }
                    // set columns to autosize
                    for ($i = 1; $i <= $column_count; $i++) {
                        $column = Coordinate::stringFromColumnIndex($i);
                        $event->sheet->getColumnDimension($column)->setAutoSize(true);
                    }
                }

            },
        ];
    }
}
