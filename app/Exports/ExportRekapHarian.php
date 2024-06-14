<?php

namespace App\Exports;

use App\Models\Presensi\TotalPresensiDetail;
use App\Models\User;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeSheet;
use PhpOffice\PhpSpreadsheet\Style\Table as TableStyle;
use PhpOffice\PhpSpreadsheet\Worksheet\Table;
class ExportRekapHarian implements FromCollection, ShouldAutoSize, WithStyles, WithEvents,WithHeadings
{
    protected $kodeSkpd;
    protected $dateStart;
    protected $dateEnd;
    protected $mTotalPresensiDetail;
    protected $tanggalAwalAkhir;
    function __construct($dateStart,$dateEnd)
    {
        $this->dateStart = $dateStart;
        $this->dateEnd = $dateEnd;
        $this->tanggalAwalAkhir = new DatePeriod(
            new DateTime($this->dateStart),
            new DateInterval('P1D'),
            new DateTime($this->dateEnd."+1 Days")
        );
    }
    public function headings(): array
    {
        $header =  [
            'NO',
            'NIP',
            'NAMA',
            'JABATAN'
        ];
        foreach($this->tanggalAwalAkhir as $tgl){
            $h = $tgl->format("F-d");
            array_push($header,$h);
        }
        return $header;
    }
    public function collection()
    {
        set_time_limit(10000);
        ini_set('memory_limit', '256M');
        $tanggalAwalAkhir = $this->tanggalAwalAkhir;
        $colspan = 0;
        $kodeSkpd = $this->kodeSkpd;
        $mUsers = User::where('owner',0)->when(($kodeSkpd  != 0),function($q)use($kodeSkpd){
            return $q->whereHas('riwayat_jabatan',function ($q)use($kodeSkpd){
                        $q->where('is_akhir',1);
                        $q->where('kode_skpd',$kodeSkpd);
                    });
        });
        $this->mTotalPresensiDetail = TotalPresensiDetail::whereBetween('tanggal',[$this->dateStart, $this->dateEnd])->get()  ;
        $maxDate = $this->mTotalPresensiDetail->max("tanggal");
        $dt = [];
        $i = 0;
        if($mUsers->get()->count() == 0){
            $mUsers = User::role('pegawai');
            // dd($mUsers->get()->count());
            foreach($mUsers as $user){
                foreach ($tanggalAwalAkhir as $tanggal ) {
                    $dt[$i] = "-";
                    $colspan++;
                }
                $dt[$i] = 0;
                $i++;
            }
        }else{
            foreach($mUsers->get() as $user){
                $dt[$i][] = $i+1;
                $dt[$i][] = $user->nip;
                $dt[$i][] = $user->getFullName();
                $dt[$i][] = $nama_jabatan ?? "-";
                foreach ($tanggalAwalAkhir as $tanggal ) {
                    $colspan++;
                    $result = "";

                    // $this->hadir = 0;
                    $detailPresensi = $this->getInmTotalPresensiDetail($tanggal->format('Y-m-d'),$user->nip);
                    $status = $detailPresensi?->status;
                    $timeAbsen = [];
                    if(strtotime($tanggal->format('Y-m-d')) <= strtotime($maxDate)){
                        if(is_null($status)){
                            $status = "3";
                        }
                    }
                    $status = explode(",",$status);
                    if($status[0] == ""){
                        $status = [];
                    }
                    if (count($status) > 0) {
                        $statusAbsen = [];
                        foreach ($status as $value) {
                            $statusAbsen[] = convertStatusAbsenCode($value);
                        }

                        if($detailPresensi){
                            $timeAbsen[] = date("H:i:s",strtotime($detailPresensi->tanggal_datang));
                            if($detailPresensi->tanggal_pulang){
                                $timeAbsen[] = date("H:i:s",strtotime($detailPresensi->tanggal_pulang));
                            }
                        }
                        $result = "[".implode(",",$statusAbsen)."]".((count($timeAbsen)>0)?" ".implode(" - ",$timeAbsen):"");
                    }else {
                        $hariSabtuMinggu = cekHariAkhirPekan($tanggal->format('Y-m-d'));
                        $hariLibur = cekHariLibur($tanggal->format('Y-m-d'));
                        if($hariLibur || $hariSabtuMinggu){
                            $result = 'L';
                        }
                        $result = '-';
                    }
                    $dt[$i][] = $result;

                }
                $hadir = 0;
                foreach ($tanggalAwalAkhir as $tanggal ) {
                    // $this->hadir = 0;

                    $detailPresensi = $this->getInmTotalPresensiDetail($tanggal->format('Y-m-d'),$user->nip);
                    $status = $detailPresensi?->status;
                    $status = collect(explode(",",$status));
                    $statusPresensi = collect(["1","2","5","6","7","8"]);
                    if ($status->count() != 0) {
                        $intersect = $status->intersect($statusPresensi);
                        if($intersect->isNotEmpty()){
                            $hadir++;
                        }
                    }

                }
                $dt[$i][] = $hadir;

                #jabatan
                $jabatan = array_key_exists('0', $user->jabatan_akhir->toArray()) ? $user->jabatan_akhir[0] : null;
                $tingkat = $jabatan?->tingkat;
                $nama_jabatan =  $tingkat?->nama;

                $i++;
            }
        }
        // dd(collect($dt));
        return collect($dt);
        // return view("laporan.presensi.harian",[
        //     "data"=>$dt,
        //     "tanggalAwalAkhir"=>$tanggalAwalAkhir,
        //     "colspan"=>$colspan,
        // ]);
    }
    function getInmTotalPresensiDetail($tanggal,$nip)
    {
        // dd($this->mTotalPresensiDetail);
        $result = null;
        foreach ($this->mTotalPresensiDetail as $value) {
            if($tanggal == $value->tanggal && $nip == $value->nip){
                $result = $value;
                return $result;
            }
        }
        return $result;
    }
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1 => ['font' => ['bold' => true]]
        ];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();

                $cellRange = 'A1:' . $highestColumn . $highestRow; // All cells
                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                ];

                $sheet->getStyle($cellRange)->applyFromArray($styleArray);
                // $sheet->mergeCells('A1:E1');
            },
        ];
    }

}
