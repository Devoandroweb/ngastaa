<?php

namespace App\Exports;

use App\Models\AppStatusFunction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportTemplateProtection implements FromCollection, WithEvents,WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect([[
            AppStatusFunction::whereName('excel_template_pegawai_version')->first()?->value
        ]]);
    }
    function registerEvents() : array {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->setSheetState(Worksheet::SHEETSTATE_HIDDEN);
            }
        ];
    }
    function title(): String {
        return 'Template Code';
    }

}
