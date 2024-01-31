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
use PhpOffice\PhpSpreadsheet\Collection\Cells;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Protection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportTemplateImportPegawai implements FromCollection, WithHeadings, WithEvents, WithStyles, WithTitle, WithStartRow
{

    protected  $selects;
    protected  $row_count;
    protected  $column_count;
    protected  $sizeRowJabatan;
    protected  $sizeRowDivisi;
    protected  $kodeSkpd;

    public function __construct($sizeRowJabatan,$sizeRowDivisi,$kodeSkpd)
    {
        $jenisKelamin = ['Laki-Laki','Perempuan'];
        $agama = ['Islam', 'Kristen', 'Hindu', 'Budha', 'Kongucu', 'Katholik', 'Protestan'];
        $statusKawin = ['Menikah','Belum Menikah','Cerai Hidup','Cerai Mati'];
        $golDarah = ['A','B','AB','O'];
        $statusPegawai = StatusPegawai::orderBy('nama')->pluck('nama')->toArray();
        $divisi = Skpd::orderBy('nama')->get(['kode_skpd','nama']);
        $jabatan = Tingkat::orderBy('nama')->limit(23)->get(['kode_tingkat','nama']);
        $this->sizeRowJabatan = $sizeRowJabatan;
        $this->sizeRowDivisi = $sizeRowDivisi;
        $this->kodeSkpd = $kodeSkpd;
        // dd($jabatan);
        // dd($divisi);
        $optionDivisi = [];
        foreach ($divisi as $value) {
            $optionDivisi[] = truncateText($value->kode_skpd." | ".$value->nama,15);
        }

        $optionJabatan = [];
        foreach ($jabatan as $value) {
            $valueJabatan = ucwords(str_replace([".",","],"",$value->nama));
            if(in_array($valueJabatan,$optionJabatan)){
                continue;
            }else{
                // $optionJabatan[] = str_replace([".",","],"",$value->nama);
                if("Kasie Cab Muntilan" == $valueJabatan){
                    continue;
                }
                $optionJabatan[] = $valueJabatan;
            }
        }
        // dd($optionJabatan);
        //$departments=ModelName::pluck('name')->toArray(); You can get values from a model or DB Facade
        $selects=[];
        if($this->kodeSkpd){
            $selects = [  //selects should have column_name and options
                ['columns_name'=>'H','options'=>$jenisKelamin], //Column H has heading departments. See headings() method below
                ['columns_name'=>'I','options'=>$agama],
                ['columns_name'=>'J','options'=>$statusKawin],
                ['columns_name'=>'K','options'=>$golDarah],
                ['columns_name'=>'Q','options'=>$statusPegawai],
                ['columns_name'=>'R','options'=>$optionJabatan],
            ];
        }else{
            $selects = [  //selects should have column_name and options
                ['columns_name'=>'H','options'=>$jenisKelamin], //Column H has heading departments. See headings() method below
                ['columns_name'=>'I','options'=>$agama],
                ['columns_name'=>'J','options'=>$statusKawin],
                ['columns_name'=>'K','options'=>$golDarah],
                ['columns_name'=>'Q','options'=>$statusPegawai],
                ['columns_name'=>'R','options'=>$optionDivisi],
                ['columns_name'=>'S','options'=>$optionJabatan],
            ];
        }
        // dd($selects);
        $this->selects=$selects;
        $this->row_count=1000;//number of rows that will have the dropdown
        $this->column_count=19;//number of columns to be auto sized
    }
    public function collection()
    {
        return collect([]);
    }
    function startRow() : Int {
        return 2;
    }

    public function headings(): array
    {
        $heading = [
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
            "Jabatan"
        ];

        if (!$this->kodeSkpd) {
            // Menyisipkan "Divisi" di urutan nomor 2 dari belakang
            array_splice($heading, -1, 0, "Divisi");
        }

        return $heading;

    }

    public function styles(Worksheet $sheet)
    {

        // Make sure you enable worksheet protection if you need any of the worksheet or cell protection features!

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
                $sheet = $event->sheet;
                $row_count = $this->row_count;
                $column_count = $this->column_count;
                foreach ($this->selects as $select) {
                    $drop_column = $select['columns_name'];
                    $options = $select['options'];
                    // if($drop_column == "R"){
                    //     // dd(sprintf('"%s"', implode(',', $options)));
                    //     dd($options,);
                    // }
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

                    // $validation->setFormula1(sprintf('"%s"', implode(',', $options)));
                        // $validation->setFormula1('=Jabatan!'.$this->sizeRowJabatan);
                    if($this->kodeSkpd == null){
                        if($drop_column == "R"){
                            $validation->setFormula1('=Divisi!$B$2:$B$'.$this->sizeRowDivisi+1);
                        }elseif($drop_column == "S"){
                            $validation->setFormula1('=Jabatan!$D$2:$D$'.$this->sizeRowJabatan+1);
                        }else{
                            $validation->setFormula1(sprintf('"%s"', implode(',', $options)));
                        }
                    }else{
                        if($drop_column == "R"){
                            // dd($this->sizeRowJabatan);
                            $validation->setFormula1('=Jabatan!$D$2:$D$'.$this->sizeRowJabatan+1);
                        }else{
                            $validation->setFormula1(sprintf('"%s"', implode(',', $options)));
                        }
                    }
                        // =Sheet2!$A$1:INDEX(Sheet2!$A$1:$A$20, COUNTA(Sheet2!$A$1:$A$20))

                    // if($drop_column == "R"){
                    //     $validation->setFormula1('"Referensi Divisi dan Jabatan"!$D$3:$D$80');
                    // }else{
                    // }

                    // Clone validation to remaining rows
                    for ($i = 3; $i <= $row_count; $i++) {
                        $cell = $event->sheet->getCell("{$drop_column}{$i}");
                        $cell->setDataValidation(clone $validation);

                    }

                    // for ($i = 1; $i <= $column_count; $i++) {
                    //     $column = Coordinate::stringFromColumnIndex($i);
                    //     $event->sheet->getColumnDimension($column)->setAutoSize(true);
                    // }
                }
                $sheet->getStyle('G2:G4000')
                    ->getNumberFormat()
                    ->setFormatCode("dd/mm/yyyy");
                $sheet->getStyle('M2:M4000')
                    ->getNumberFormat()
                    ->setFormatCode(NumberFormat::FORMAT_TEXT);

                $sheet->getParent()->getActiveSheet()->getProtection()->setSheet(true);

                // lock all cells then unlock the cell
                $cellStyle = "";
                // dd($this->kodeSkpd);
                if($this->kodeSkpd){
                    $cellStyle = 'A2:R4000';
                }else{
                    $cellStyle = 'A2:S4000';
                }
                $sheet->getParent()->getActiveSheet()
                    ->getStyle($cellStyle)
                    ->getProtection()
                    ->setLocked(Protection::PROTECTION_UNPROTECTED);

                $sheet->getParent()->getActiveSheet()->getStyle('B')->getAlignment()->setVertical("middle");
                $sheet->getParent()->getActiveSheet()->getStyle('B')->getAlignment()->setHorizontal("left");
                $sheet->getParent()->getActiveSheet()->getStyle('M')->getAlignment()->setVertical("middle");
                $sheet->getParent()->getActiveSheet()->getStyle('M')->getAlignment()->setHorizontal("left");
                $columnWith = [
                    ["A",6],
                    ["B",15],
                    ["C",15],
                    ["D",15],
                    ["E",30],
                    ["F",15],
                    ["G",15],
                    ["H",15],
                    ["J",20],
                    ["K",20],
                    ["L",20],
                    ["M",30],
                    ["N",30],
                    ["O",50],
                    ["P",50],
                    ["Q",10],
                    ["R",25],
                    ["S",25],
                ];
                foreach ($columnWith as $key) {
                    $event->sheet->getColumnDimension($key[0])->setWidth($key[1]);
                }
                $event->sheet->getStyle('1')->getAlignment()->setHorizontal('center');
                $event->sheet->freezePane('F1');
            },
        ];
    }
    public function title(): string
    {
        return 'Template';
    }
}
