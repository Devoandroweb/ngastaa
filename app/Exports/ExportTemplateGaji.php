<?php

namespace App\Exports;

use App\Models\Kabupaten;
use App\Models\Master\Payroll\Pengurangan;
use App\Models\Master\Payroll\Tambahan;
use App\Models\Master\Payroll\Tunjangan;
use App\Models\Master\Payroll\Umk;
use App\Models\Payroll\DaftarKurangPayroll;
use App\Models\User;
use App\Repositories\Pegawai\PegawaiRepository;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Protection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PHPExcel_Style_NumberFormat;
class ExportTemplateGaji implements FromView, WithStartRow, ShouldAutoSize, WithStyles, WithCustomStartCell, WithEvents
{
    protected $pegawaiRepository;
    protected $pegawais;
    protected $potongans;
    protected $tunjangans;
    protected $bonus;
    protected $countTunjangan;
    protected $countBonus;
    protected $countPotongan;
    function __construct($pegawaiRepository){
        $this->pegawaiRepository = $pegawaiRepository;
        $this->potongans = Pengurangan::get();
        $this->tunjangans = Tunjangan::get();
        $this->bonus = Tambahan::get();
        $this->countTunjangan = $this->tunjangans->count();
        $this->countPotongan = $this->potongans->count();
        $this->countBonus = $this->bonus->count();
        $this->pegawais = $this->pegawaiRepository->allPegawaiWithRole()->get();
    }
    public function startCell(): string
    {
        return 'C3'; // Sel tempat freeze pane harus dimulai
    }
    public function view(): View
    {
        $pegawais = $this->pegawais;
        $potongans = $this->potongans;
        $bonus = $this->bonus;

        $tunjangans = $this->tunjangans;
        $countTunjangan = $this->countTunjangan;
        $countBonus = $this->countBonus;
        $countPotongan = $this->countPotongan;
        $gajiUMK = Umk::get();
        return view('pages.payroll.generate.template',compact('pegawais','potongans','gajiUMK','tunjangans','bonus','countTunjangan','countPotongan','countBonus'));
    }
    public function startRow(): int
    {
        return 5;
    }
    public function styles(Worksheet $sheet)
    {

        // Make sure you enable worksheet protection if you need any of the worksheet or cell protection features!
        $sheet->getParent()->getActiveSheet()->getProtection()->setSheet(true);
        $cellOfFill = excelColumn(12+$this->countTunjangan+$this->countBonus+$this->countPotongan);

        // lock all cells then unlock the cell
        $sheet->getParent()->getActiveSheet()
            ->getStyle('G3:'.$cellOfFill.$this->pegawais->count()+2)
            ->getProtection()
            ->setLocked(Protection::PROTECTION_UNPROTECTED);

        $sheet->getStyle('G3:'.$cellOfFill.$this->pegawais->count()+2)
            ->getNumberFormat()
            ->setFormatCode(' #,##0');
        // styling first row
        // $sheet->getStyle(1)->getFont()->setBold(true);

        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
            2    => ['font' => ['bold' => true]],
        ];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {

                $workSheet = $event->sheet->getDelegate();
                $workSheet->freezePane('D3'); // freezing here

                $validationForNumber = $workSheet->getCell('G3')->getDataValidation();
                $validationForNumber->setType(DataValidation::TYPE_WHOLE);
                $validationForNumber->setErrorStyle(DataValidation::STYLE_STOP);
                $validationForNumber->setShowInputMessage(true);
                $validationForNumber->setShowErrorMessage(true);
                $validationForNumber->setErrorTitle('Invalid input');
                $validationForNumber->setError('Hanya boleh menggunakan Angka.');
                $validationForNumber->setFormula1(1);

                $countColumn = Coordinate::columnIndexFromString($workSheet->getHighestColumn());

                foreach ($this->pegawais as $iteration => $value) {
                    if(in_array($iteration,[0,1,2])){
                        continue;
                    }
                    # Looping banyak colom yang di gunakan, arti dri $countColumn+1, karena array di mulai dari 0 jadi biar sesuai, maka di tambah 1
                    for ($i=7; $i < $countColumn+1; $i++) {
                        $column = excelColumn($i);
                        $exceptColumn = [
                            excelColumn($this->countTunjangan+8),
                            excelColumn($this->countTunjangan+9+$this->countBonus),
                            excelColumn($this->countTunjangan+9+$this->countBonus+1),
                            excelColumn($this->countTunjangan+9+$this->countBonus+1+$this->countPotongan+1),
                            excelColumn($this->countTunjangan+9+$this->countBonus+1+$this->countPotongan+1+1),
                        ];
                        $cell = excelCoordinate($iteration,$i);
                        if(in_array($column,$exceptColumn)){
                            $validationForNotFill = $workSheet->getCell($column.$iteration)->getDataValidation();
                            $validationForNotFill->setType(DataValidation::TYPE_WHOLE);
                            $validationForNotFill->setErrorStyle(DataValidation::STYLE_STOP);
                            $validationForNotFill->setShowInputMessage(true);
                            $validationForNotFill->setShowErrorMessage(true);
                            $validationForNotFill->setErrorTitle('Invalid input');
                            $validationForNotFill->setError('Tidak boleh di ubah.');
                            $validationForNotFill->setFormula1(1);
                            $workSheet->setDataValidation($cell, $validationForNotFill);
                        }else{
                            $workSheet->setDataValidation($cell, $validationForNumber);

                        }
                    }
                }
            },
        ];
    }
}
