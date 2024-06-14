<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Events\AfterSheet;
class PresentTodayExcel implements FromView, ShouldAutoSize, WithStyles, WithEvents
{

    public function view(): View
    {
        $presensiToday = getPresensi(date("Y-m-d"));
        $nipArray = array_column($presensiToday, 'nip');
        $presensiToday = User::selectRaw('users.*, riwayat_jabatan.*')
                                    ->leftJoin('riwayat_jabatan', 'riwayat_jabatan.nip', 'users.nip')
                                    ->where('riwayat_jabatan.is_akhir', 1)
                                    ->whereIn('users.nip',$nipArray)
                                    ->get();
        return view('laporan.presensi.presensi-today', [
            'presensiToday' => $presensiToday
        ]);
    }
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1 => ['font' => ['bold' => true,'size' => 15,]],
            2 => ['font' => ['bold' => true]],
        ];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();

                $cellRange = 'A2:' . $highestColumn . $highestRow; // All cells
                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                ];

                $sheet->getStyle($cellRange)->applyFromArray($styleArray);
                $sheet->mergeCells('A1:E1');
            },
        ];
    }
}
