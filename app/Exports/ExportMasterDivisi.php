<?php

namespace App\Exports;

use App\Models\Master\Skpd;
use App\Models\Master\Tingkat;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportMasterDivisi implements FromArray, WithTitle, WithHeadings, WithStyles, ShouldAutoSize, WithEvents
{
    protected $sizeColumns = 4;
    protected $sizeRows;
    protected $divisi;
    function __construct($divisi){
        $this->divisi = $divisi;
    }
    public function headings(): array
    {
        return [
            "KODE DIVISI",
            "NAMA DIVISI",
        ];
    }
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }
    public function array() : array
    {

        $result = [];

        $this->sizeRows = $this->divisi->count();
        // dd($data);
        foreach ($this->divisi as $value) {
            $result[] = [
                $value->kode_skpd,
                $value->nama
            ];
        }

        return $result;
    }
    public function title(): string
    {
        return 'Divisi';
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {

                $columnsCenter = ['A','B1','D1'];
                foreach ($columnsCenter as $value) {
                    $event->sheet->getDelegate()->getStyle($value)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $event->sheet->getDelegate()->getStyle($value)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

                    $event->sheet->getDelegate()->getStyle($value)->getAlignment()->setWrapText(true);
                    $event->sheet->getDelegate()->getStyle($value)->getAlignment()->setIndent(1);
                }

                $abjadCols = ['A','B'];
                for ($i=1; $i < $this->sizeRows + 2; $i++) {
                    # code...
                    foreach ($abjadCols as $value) {
                        # code...
                        $event->sheet->getDelegate()->getStyle($value.$i)->applyFromArray([
                            'borders' => [
                                'outline' => [
                                    'borderStyle' => Border::BORDER_THIN,
                                    'color' => ['argb' => '000000'],
                                ],
                            ],
                        ]);
                        if($value = "C"){
                            $event->sheet->getDelegate()->getStyle($value.$i)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
                        }
                    }
                }


            },
        ];
    }
}
