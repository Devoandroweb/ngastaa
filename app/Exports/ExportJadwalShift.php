<?php

namespace App\Exports;

use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Master\Shift;
use App\Models\Master\Skpd;
use App\Models\MJadwalShift;
use App\Models\Presensi\TotalPresensiDetail;
use App\Models\User;
use DateInterval;
use DatePeriod;
use DateTime;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\BeforeSheet;

class ExportJadwalShift implements FromView, WithTitle,ShouldAutoSize,WithEvents
{
    protected $pegawaiRepository;
    protected $kodeSkpd;
    protected $dateStart;
    protected $dateEnd;
    function __construct($pegawaiRepository,$dateStart,$dateEnd,$kodeSkpd){
        $this->pegawaiRepository = $pegawaiRepository;
        $this->dateStart = $dateStart;
        $this->dateEnd = $dateEnd;
        $this->kodeSkpd = $kodeSkpd;

    }
    function title():string{
        return "penjadwalan-shift-".date("YmdHis");
    }
    public function view() : View
    {

        $dateStart = date('Y-m-01');
        $dateEnd = date('Y-m-t');
        $periodeBulan = date("Y-m");
        $rawColumn = [];

        $mJadwalShift = MJadwalShift::whereBetween('tanggal',[$this->dateStart,$this->dateEnd])->get();

        if ($this->dateStart && $this->dateEnd ) {
            $dateStart = date("Y-m-d",strtotime($this->dateStart));
            $dateEnd = date("Y-m-d",strtotime($this->dateEnd));
        }
        $mUsers = $this->pegawaiRepository->allPegawaiWithRole($this->kodeSkpd,false)->get();

        $tanggalAwalAkhir = new DatePeriod(
            new DateTime($dateStart),
            new DateInterval('P1D'),
            new DateTime($dateEnd."+1 Days")
        );
        // dd($mUsers);
        return view('laporan.penjadwalanshift.index',compact('mJadwalShift','tanggalAwalAkhir','mUsers'));
    }
    function registerEvents():array{
        return [
            BeforeSheet::class => function (BeforeSheet $event) {
                $event->sheet
                    ->getPageSetup()
                    ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
            },
        ];
    }
}
