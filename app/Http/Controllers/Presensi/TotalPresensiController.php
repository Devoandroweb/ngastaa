<?php

namespace App\Http\Controllers\Presensi;

use App\Http\Controllers\Controller;
use App\Models\Master\Skpd;
use App\Models\Presensi\TotalIzin;
use App\Models\Presensi\TotalIzinDetail;
use App\Models\Presensi\TotalPresensi;
use App\Models\Presensi\TotalPresensiDetail;
use App\Models\User;
use App\Repositories\Izin\IzinRepository;
use App\Repositories\TotalPresensi\TotalPresensiRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class TotalPresensiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $totalPresensiRepository;
    private $izinRepository;
    private $periode_bulan;
    private $dataTotalIzin;
    function __construct(
        TotalPresensiRepository $totalPresensiRepository,
        IzinRepository $izinRepository,
        TotalIzin $mdTotalIzin)
    {
        $this->totalPresensiRepository = $totalPresensiRepository;
        $this->izinRepository = $izinRepository;

        $this->periode_bulan = date("Y-m");
        $this->dataTotalIzin = $mdTotalIzin->get();
    }
    public function index()
    {
        // $role = role('opd');
        // dd($this->totalPresensiRepository->calculatePresensi($role));
        $skpd = Skpd::all();
        return view("pages.daftarpresensi.totalpresensi.index",compact('skpd'));
    }
    public function detail_absen(User $user,$status)
    {
        return view("pages.daftarpresensi.totalpresensi.detail_absen",compact('user','status'));
    }
    public function detail_izin(User $user)
    {
        return view("pages.daftarpresensi.totalpresensi.detail_izin",compact('user'));
    }
    public function datatable(DataTables $dataTables){
        $role = role('opd');
        $skpd = request()->query('skpd');
        $skpd = ($skpd == 0) ? null : $skpd;
        // dd($skpd);
        $mdTotalPresensi = User::role('pegawai');
        if($role){
            $mdTotalPresensi->when($role, function ($qr) {
                $user = auth()->user()->jabatan_akhir;
                $jabatan = array_key_exists('0', $user->toArray()) ? $user[0] : null;
                $skpd = '';
                if ($jabatan) {
                    $skpd = $jabatan->kode_skpd;
                }
                $qr->join('riwayat_jabatan', function ($qt) use ($skpd) {
                    $qt->on('riwayat_jabatan.nip', 'users.nip')
                        ->where('riwayat_jabatan.kode_skpd', $skpd)
                        ->where('riwayat_jabatan.is_akhir', 1);
                });
            })->with('totalPresensi')->get();
        }else{
            $mdTotalPresensi->when($skpd, function ($qr) use ($skpd) {
                $qr->join('riwayat_jabatan', function ($qt) use ($skpd) {
                    $qt->on('riwayat_jabatan.nip', 'users.nip')
                        ->where('riwayat_jabatan.kode_skpd', $skpd)
                        ->where('riwayat_jabatan.is_akhir', 1);
                });
            })
            ->with('totalPresensi')->get();
        }
        // dd($mdTotalPresensi[3]->jabatan_akhir()->first());
        return $dataTables->of($mdTotalPresensi)
            ->addColumn('jabatan',function($row){
                $jabatan = array_key_exists('0', $row->jabatan_akhir->toArray()) ? $row->jabatan_akhir[0] : null;
                // dd($jabatan);
                $tingkat = $jabatan?->tingkat;
                $nama_jabatan =  $tingkat?->nama;
                return $nama_jabatan ?? "-";
            })
            ->editColumn('nama_pegawai',function($row){
                return $row->getFullName();
            })
            ->addColumn('masuk',function($row){
                return $row->totalPresensi->masuk;
            })
            ->addColumn('telat',function($row){
                return $row->totalPresensi->telat; 
            })
            ->addColumn('alfa',function($row){
                return $row->totalPresensi->alfa;
            })
            ->addColumn('izin',function($row){
                return $this->izinRepository->calculateTotalIzin($row->nip);
            })
            ->addColumn('href_masuk',function($row){
                return route('presensi.total_presensi.detail_absen',['user'=>$row,'status'=>1]);
            })
            ->addColumn('href_telat',function($row){
                return route('presensi.total_presensi.detail_absen',['user'=>$row,'status'=>2]);
            })
            ->addColumn('href_alfa',function($row){
                return route('presensi.total_presensi.detail_absen',['user'=>$row,'status'=>3]);

            })
            ->addColumn('href_izin',function($row){
                return route('presensi.total_presensi.detail_izin',['user'=>$row]);
            })
            ->rawColumns(['masuk','telat','alfa','izin'])
            ->addIndexColumn()
            ->toJson();
    }
    
    public function datatable_detail_izin($nip,DataTables $dataTables){
        $totalCutiDetail = TotalIzinDetail::with('izin')->where('nip',$nip);
        // dd($totalCutiDetail);
        return $dataTables->of($totalCutiDetail)
            ->addColumn('nama_izin',function($row){
                return $row->izin->nama;
            })
            ->editColumn('tanggal',function($row){
                return tanggal_indo($row->tanggal);
            })
            ->rawColumns(['nama_izin'])
            ->addIndexColumn()
            ->toJson();
    }
    public function datatable_detail_absen($nip,$status,DataTables $dataTables){
        $totalIzinDetail = TotalPresensiDetail::where('nip',$nip)->where('status',$status);
        // dd($totalIzinDetail);
        return $dataTables->of($totalIzinDetail)
            ->addColumn('status',function($row){
                return generateStatusAbsen($row->status);
            })
            ->editColumn('tanggal',function($row){
                return tanggal_indo($row->tanggal);
            })
            ->rawColumns(['status'])
            ->addIndexColumn()
            ->toJson();
    }
}
