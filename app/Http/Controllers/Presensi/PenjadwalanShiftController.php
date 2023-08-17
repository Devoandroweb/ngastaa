<?php

namespace App\Http\Controllers\Presensi;

use App\Exports\ExportJadwalShift;
use App\Http\Controllers\Controller;
use App\Models\Master\Shift;
use App\Models\Master\Skpd;
use App\Models\MJadwalShift;
use App\Models\User;
use App\Repositories\Pegawai\PegawaiRepository;
use DateInterval;
use DatePeriod;
use DateTime;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class PenjadwalanShiftController extends Controller
{
    protected $mJadwalShift;
    protected $shift;
    protected $pegawaiRepository;
    function __construct(
        MJadwalShift $mJadwalShift,
        Shift $shift,
        PegawaiRepository $pegawaiRepository
    ){
        $this->mJadwalShift = $mJadwalShift->with('shift');
        $this->shift = $shift->get();
        $this->pegawaiRepository = $pegawaiRepository;
    }
    public function index()
    {
        $skpd = Skpd::orderBy('nama')->get();
        $shift = Shift::get();
        // dd($shift);

        return view('pages.penjadwalanshift.index',compact('skpd','shift'));
    }
    function update(){
        try {
            $data = request()->except(['method','uri','ip']);
            // dd($data);
            $data['tanggal'] = date("Y-m-d",strtotime($data['tanggal']));
            MJadwalShift::updateOrCreate([
                'tanggal' => request('tanggal'),
                'nip' => request('nip')
            ],[
                'tanggal' => request('tanggal'),
                'nip' => request('nip'),
                'kode_shift' => request('kode_shift')
            ]);
            return response()->json([
                'status' => TRUE,
                'message' => 'Berhasil Update Shift'
            ],200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => FALSE,
                'message' => 'Gagal Update Shift',
                'error' => $th->getMessage()
            ],500);
        }


    }
    function export(){
        $dateStart = request()->query('date_start');
        $dateEnd = request()->query('date_end');
        $ext = request()->query('ext');

        $kodeSkpd = request()->query('kode_skpd');

        $dateStart = date("Y-m-d",strtotime($dateStart));
        $dateEnd = date("Y-m-d",strtotime($dateEnd));
        $response = Excel::download(new ExportJadwalShift($this->pegawaiRepository,$dateStart,$dateEnd,$kodeSkpd),"penjadwalan-shift-{$dateStart}-{$dateEnd}.xlsx",\Maatwebsite\Excel\Excel::XLSX);
        ob_end_clean();
        return $response;
    }
    public function datatable(DataTables $dataTables)
    {
        $search = request()->query('search')['value'];
        $kodeSkpd = request()->query('kode_skpd');

        $dateStart = date('Y-m-01');
        $dateEnd = date('Y-m-t');
        $periodeBulan = date("Y-m");
        $rawColumn = [];
        // dd(request()->query('date_start'), request()->query('date_end'));
        if (request()->query('date_start') && request()->query('date_end')) {
            $dateStart = date("Y-m-d",strtotime(request()->query('date_start')));
            $dateEnd = date("Y-m-d",strtotime(request()->query('date_end')));
            $periodeBulan = null;
        }
        $this->mJadwalShift = $this->mJadwalShift->whereBetween('tanggal',[$dateStart,$dateEnd])->get();
        // dd($this->mJadwalShift,$dateStart,$dateEnd);
        $mUsers = User::role('pegawai')->where('owner',0)->when($search,function($q)use($search){
            // dd($search);
            return $q->where('users.name','like','%'.$search.'%');
        })->when(($kodeSkpd  != 0),function($q)use($kodeSkpd){
            return $q->whereHas('riwayat_jabatan',function ($q)use($kodeSkpd){
                        $q->where('is_akhir',1);
                        $q->where('kode_skpd',$kodeSkpd);
                    });
        });


        $tanggal_awal_akhir = new DatePeriod(
            new DateTime($dateStart),
            new DateInterval('P1D'),
            new DateTime($dateEnd."+1 Days")
        );

        if($mUsers->get()->count() == 0){
            $mUsers = User::role('pegawai')->when($search,function($q)use($search){
                        return $q->where('users.name','like','%'.$search.'%');
                    });
            // dd($mUsers->get()->count());
            $dt = DataTables::of($mUsers);
            foreach ($tanggal_awal_akhir as $tanggal ) {
                $rawColumn[] = "day_{$tanggal->format('d')}";
                $dt->addColumn("day_{$tanggal->format('d')}", function($row)use($tanggal,$rawColumn){
                    return '-';
                });
            }
            $dt->addColumn('rekap',function($row){
                return 0;
            });
        }else{
            // dd($mUsers->get());

            $dt = DataTables::of($mUsers->select('nip','name'));

            foreach ($tanggal_awal_akhir as $i => $tanggal ) {

                $rawColumn[] = "day_{$tanggal->format('d')}";
                // $this->hadir = 0;
                $dt->addColumn("day_{$tanggal->format('d')}", function($row)use($tanggal,$i,$dt){
                    // return $this->getShift($row->kode_shift) ?? "-";

                    $jadwalShift = $this->getJadwalShift($row->nip,$tanggal->format('Y-m-d'));

                    $html = "";
                    $shift = null;


                    if($jadwalShift){
                        // dd($jadwalShift);
                        $shift = $jadwalShift->shift;
                        $html .= '<span class="badge badge-danger shift">'.$shift?->nama.'<br> ('.date('H:i',strtotime($shift?->jam_tepat_datang)).'-'.date('H:i',strtotime($shift?->jam_tepat_pulang)).')</span>';

                    }else{
                        $html .= "-";
                    }
                    $html .= "<span class='show-edit' data-kodeshift='{$shift?->kode_shift}' data-tgl='".$tanggal->format('Y-m-d')."' data-tglindo='".tanggal_indo($tanggal->format('d-m-Y'))."'><a href='#' class='btn btn-sm text-white btn-ubah btn-rounded'>Ubah</a></span>";
                    return  $html;
                });
            }
        }

        $dt->addColumn("nama_pegawai", function($row){
            return $row->name;
        });
        $dt->addColumn("jabatan", function($row){
            return $row->getNamaJabatan();
        });
        $dt->addColumn("kode_skpd", function($row){
            return $row->getDivisi()?->kode_skpd;
        });
        $dt->rawColumns($rawColumn);
        $dt->addIndexColumn();
        return $dt->toJson();
    }
    function getShift($kodeShift){
        foreach ($this->shift as $value) {
            if($kodeShift == $value->kode_shift){
                return $value->kode_shift;
            }
        }
        return null;
    }
    function getJadwalShift($nip,$tanggal){
        foreach ($this->mJadwalShift as $value) {
            if($nip == $value->nip && $tanggal == $value->tanggal){
                return $value;
            }
        }
        // dd($nip,$tanggal);
        return null;
    }
}

