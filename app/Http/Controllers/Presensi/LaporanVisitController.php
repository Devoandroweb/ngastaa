<?php

namespace App\Http\Controllers\Presensi;

use App\Http\Controllers\Controller;
use App\Models\Master\Skpd;
use App\Models\Master\Tingkat;
use App\Models\Master\Visit;
use App\Models\Pegawai\DataVisit;
use App\Repositories\Pegawai\PegawaiRepository;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class LaporanVisitController extends Controller
{
    protected $pegawaiRepository;
    // protected $pegawaiWithRole;
    function __construct(
        PegawaiRepository $pegawaiRepository
    ){
        $this->pegawaiRepository = $pegawaiRepository;
    }
    function index(){

        $skpd = Skpd::orderBy("nama")->get();
        $tingkatJabatan = Tingkat::selectRaw("nama, GROUP_CONCAT(kode_tingkat SEPARATOR ',') AS kode_tingkat")
        ->groupBy('nama');
        $tingkatJabatan = $tingkatJabatan->get();

        return view("pages.daftarpresensi.laporanvisit.index",compact('skpd','tingkatJabatan'));
    }
    function datatable(DataTables $dataTables){
        $kodeSkpd = request()->query('kode_skpd');
        $namaPegawai = request()->query('nama_pegawai');
        $kodeSkpd = ($kodeSkpd == 0) ? null : $kodeSkpd;
        $nip = request()->query('nip_pegawai');
        $nip = explode(",",$nip);

        $pegawai = $this->pegawaiRepository->allPegawaiWithRole($kodeSkpd);

        if($namaPegawai){
            $pegawai = $pegawai->where('nama_pegawai','like','%'.$namaPegawai.'%');
        }

        if(count($nip) > 0 && $nip[0] != ""){
            $pegawai = $pegawai->whereIn('nip',$nip);
        }
        $nip = $pegawai->pluck("nip")->toArray();
        $model = DataVisit::whereIn("nip",$nip)->orderByDesc('created_at');

        return $dataTables->of($model)
            ->editColumn('shift', function ($row) {
                return $row->nama_shift;
            })
            ->addColumn('nama', function ($row) {
                return "<span class='badge badge-success badge-pill badge-sm'>". $row->nip . "</span>  " . $row->pegawai?->getFullName();
            })
            ->addColumn('jabatan', function ($row) {
                $jabatan_akhir = $row->pegawai->jabatan_akhir;
                $jabatan = array_key_exists('0', $jabatan_akhir->toArray()) ? $jabatan_akhir[0] : null;

                // dd($jabatan);
                $nama_jabatan = '-';
                if ($jabatan) {
                    $tingkat = $jabatan?->tingkat;
                    $nama_jabatan =  $tingkat?->nama;
                    return $nama_jabatan;
                }
                return $nama_jabatan;
            })
            ->editColumn("foto",function ($row){
                return $row->foto();
            })
            ->addColumn('tanggal', function ($row) {
                return tanggal_indo($row->created_at);
            })
            ->addColumn('jenis_visit', function ($row) {
                if($row->visit?->jenis_visit !== null){
                    if($row->visit?->jenis_visit == 0){
                        return '<div class="badge badge-info badge-outline">Visit Baru</div>';
                    }else{
                        return '<div class="badge badge-danger badge-outline">Visit Lama</div>';
                    }
                }
                return "-";
            })
            ->editColumn('created_at',function($row){
                return date("H:i:s",strtotime($row->created_at));
            })
            ->rawColumns(['nama','jenis_visit'])
            ->addIndexColumn()
            ->toJson();
    }
}


