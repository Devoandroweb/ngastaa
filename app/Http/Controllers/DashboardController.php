<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Pegawai\PegawaiController;
use App\Http\Resources\Pegawai\PegawaiResource;
use App\Models\Master\Cuti;
use App\Models\Master\Lokasi;
use App\Models\Master\Pendidikan;
use App\Models\Master\StatusPegawai;
use App\Models\Payroll\DataPayroll;
use App\Models\Pegawai\DataPresensi;
use App\Models\Presensi\TotalPresensi;
use App\Models\Presensi\TotalPresensiDetail;
use App\Models\User;
use App\Repositories\Pegawai\PegawaiRepository;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
// use ZipStream\Bigint;

class DashboardController extends Controller
{
    protected $pegawaiRepository;
    function __construct(PegawaiRepository $pegawaiRepository)
    {
        $this->pegawaiRepository = $pegawaiRepository;


    }
    public function __invoke()
    {
        // dd(auth()->user()->getRoleNames()->toArray());

        $role = role('opd');
        $periode_bulan = date("Y-m");
        $pegawai = $this->pegawaiRepository->allPegawaiWithRole();

        $jumlah_pegawai = $pegawai->count();

        $status_pegawai = StatusPegawai::all();
        $status_pegawai_statistic = [];
        $total_status_pegawai = [];
        $nama_status_pegawai = [];
        $color_status_pegawai = [];

        # Data Kepegawaian Status Pegawai

        foreach ($status_pegawai as $key => $value) {
            $pegawai = $this->pegawaiRepository->allPegawaiWithRole();
            $total_status = $pegawai->where('kode_status',$value->kode_status)->count();

            $nama = $value->nama;

            array_push($total_status_pegawai,$total_status);
            array_push($nama_status_pegawai,$nama);
            array_push($color_status_pegawai,getColor($key));

        }
        $status_pegawai_statistic = [
            'series' => $total_status_pegawai,
            'labels' => $nama_status_pegawai,
            'colors' => $color_status_pegawai,
        ];

        # Data Kepegawaian Status Kawin
        $status_kawin = User::groupBy('kode_kawin')->pluck('kode_kawin');

        $collection = new Collection($status_kawin);
        $status_kawin = $collection->filter(function ($value) {
            return $value !== null;
        });
        $status_kawin = $status_kawin->values()->all();
        $status_kawin_statistic = [];
        $total_status_kawin = [];
        $nama_status_kawin = [];
        $color_status_kawin = [];
        $total_kawin_nikah = 0;
        foreach ($status_kawin as $key => $value) {
            $pegawai = $this->pegawaiRepository->allPegawaiWithRole();
            $total_status = $pegawai->where('kode_kawin',$value)->count();

            $nama = $value;

            array_push($total_status_kawin,$total_status);
            array_push($nama_status_kawin,ucfirst($nama));
            array_push($color_status_kawin,getColor($key));

        }
        $status_kawin_statistic = [
            'series' => $total_status_kawin,
            'labels' => $nama_status_kawin,
            'colors' => $color_status_kawin,
        ];

        // dd($status_kawin_statistic);
        # Presensi Count
        // dd($this->pegawaiRepository->allPegawaiWithRole()->get()->pluck('nip')->toArray());

        $presensi = DataPresensi::whereDate('data_presensi.created_at', date("Y-m-d"))
                    ->when($role, function ($qr) {
                        $user = auth()->user()->jabatan_akhir;
                        $jabatan = array_key_exists('0', $user->toArray()) ? $user[0] : null;
                        $skpd = '';
                        if ($jabatan) {
                            $skpd = $jabatan->kode_skpd;
                        }

                        $qr->join('riwayat_jabatan', function ($qt) use ($skpd) {
                            $qt->on('riwayat_jabatan.nip', 'data_presensi.nip')
                                ->where('riwayat_jabatan.kode_skpd', $skpd)
                                ->where('riwayat_jabatan.is_akhir', 1);
                        });
                    })
                    ->count();

        $bulan = DataPresensi::whereMonth('data_presensi.created_at', date("m"))
                ->when($role, function ($qr) {
                    $user = auth()->user()->jabatan_akhir;
                    $jabatan = array_key_exists('0', $user->toArray()) ? $user[0] : null;
                    $skpd = '';
                    if ($jabatan) {
                        $skpd = $jabatan->kode_skpd;
                    }

                    $qr->join('riwayat_jabatan', function ($qt) use ($skpd) {
                        $qt->on('riwayat_jabatan.nip', 'data_presensi.nip')
                            ->where('riwayat_jabatan.kode_skpd', $skpd)
                            ->where('riwayat_jabatan.is_akhir', 1);
                    });
                })
                ->count();

        $tahun = DataPresensi::whereYear('data_presensi.created_at', date("Y"))
                ->when($role, function ($qr) {
                    $user = auth()->user()->jabatan_akhir;
                    $jabatan = array_key_exists('0', $user->toArray()) ? $user[0] : null;
                    $skpd = '';
                    if ($jabatan) {
                        $skpd = $jabatan->kode_skpd;
                    }

                    $qr->join('riwayat_jabatan', function ($qt) use ($skpd) {
                        $qt->on('riwayat_jabatan.nip', 'data_presensi.nip')
                            ->where('riwayat_jabatan.kode_skpd', $skpd)
                            ->where('riwayat_jabatan.is_akhir', 1);
                    });
                })
                ->count();

        # Lokasi Kerja
        $lokasiVisit = Lokasi::all();
        $mapsRadar = [];
        foreach ($lokasiVisit as $lokasi) {
            array_push($mapsRadar,[
                'title' => $lokasi->nama,
                'latitude' => (float)$lokasi->latitude,
                'longitude' => (float)$lokasi->longitude,
                'color' => '#007D88'
            ]);
        }
        # Total Presensi
        $totalPresensi = TotalPresensi::where('periode_bulan',$periode_bulan)->whereIn('nip',$this->pegawaiRepository->allPegawaiWithRole()->get()->pluck('nip')->toArray())->get();

        $masuk = $totalPresensi->sum("masuk");
        $alfa = $totalPresensi->sum("alfa");

        $dataTotalPresensi = [$masuk,$alfa];
        $textTotalPresensi = ['Masuk', 'Tidak Masuk'];
        $colorTotalPresensi = ['#00E396','#FF4560'];

        $jenisIzin = Cuti::all();

        foreach ($jenisIzin as $i => $ji) {
            $detailPresensi = TotalPresensiDetail::where('kode_cuti',$ji->kode_cuti)->whereIn('nip',$this->pegawaiRepository->allPegawaiWithRole()->get()->pluck('nip')->toArray())->where('periode_bulan',$periode_bulan)->get();
            if(!is_null($detailPresensi)){
                array_push($dataTotalPresensi,$detailPresensi->count());
                array_push($textTotalPresensi,$ji->nama);
                array_push($colorTotalPresensi,getColor($i));
            }
        }
        # Data Yang Akan Selesai Kontrak
        $selesai_kontrak = User::role('opd')->selectRaw('users.*, riwayat_jabatan.tanggal_tmt')
                                    ->leftJoin('riwayat_jabatan', 'riwayat_jabatan.nip', 'users.nip')
                                    ->where('riwayat_jabatan.is_akhir', 1)
                                    ->whereMonth('riwayat_jabatan.tanggal_tmt', date("m"))
                                    ->whereYear('riwayat_jabatan.tanggal_tmt', date("Y"))
                                    ->get();


        $selesai_kontrak = PegawaiResource::collection($selesai_kontrak);



        $titlePage = "Dashboard ".env('app_name');

        return view('dashboard',compact(
            'status_pegawai_statistic',
            'status_kawin_statistic',
            'titlePage',
            'jumlah_pegawai',
            'presensi',
            'bulan',
            'tahun',
            'selesai_kontrak',
            'mapsRadar',
            'lokasiVisit',
            'dataTotalPresensi',
            'textTotalPresensi',
            'colorTotalPresensi'
        ));
    }
    public function datatable(DataTables $dataTables)
    {
        $pegawai = User::selectRaw('users.*, riwayat_jabatan.tanggal_tmt')
        ->leftJoin('riwayat_jabatan', 'riwayat_jabatan.nip', 'users.nip')
        ->where('riwayat_jabatan.is_akhir', 1)
        ->whereMonth('riwayat_jabatan.tanggal_tmt', date("m"))
        ->whereYear('riwayat_jabatan.tanggal_tmt', date("Y"))
        ->get();
        $pegawai = PegawaiResource::collection($pegawai);
        // dd($pegawai->resource);
        return $dataTables->of($pegawai)
        ->addColumn('divisi_kerja', function ($row) {
            $skpd = "-";
            $jabatan = array_key_exists('0', $row->jabatan_akhir->toArray()) ? $row->jabatan_akhir[0] : null;
            if($jabatan){
                $skpd = $jabatan?->skpd?->nama;
            }
            return $skpd;
        })->addColumn('nama_jabatan', function ($row) {
            $jabatan = array_key_exists('0', $row->jabatan_akhir->toArray()) ? $row->jabatan_akhir[0] : null;
            $nama_jabatan = $jabatan?->tingkat?->nama;
            return $nama_jabatan ?? "-";
        })
        ->addColumn('tanggal_tmt', function ($row) {
            return tanggal_indo($row->tanggal_tmt);
        })
        // ->rawColumns(['images'])
        ->addIndexColumn()
        ->toJson();
    }
    public function payrollStatistic()
    {
        $dateRange = request()->query("d");

        $payroll = DataPayroll::query();
        if($dateRange == null){
            $payroll = $payroll->get();
        }else{
            $dateRange = explode(",",$dateRange);
            $payroll = $payroll->whereBetween('created_at',$dateRange)->get();
        }
        $categories = [];
        $dataPayroll = [];
        $totalPayroll = 0;
        $created_at = "";
        $total = 0;
        foreach ($payroll as $pay) {
            $totalPayroll += (int)$pay->total;
            $total += (int)$pay->total;

            if($created_at != $pay->created_at){
                $dataPayroll[] = $total;
                $categories[] = date("m-Y",strtotime($pay->created_at));
                $total = 0;
                $created_at = $pay->created_at;
            }
        }
        // dd();
        $data['max_range_total'] = (int)$this->getNominalRange($totalPayroll);
        $data['categories'] = $categories;
        $data['data'] = $dataPayroll;
        return response()->json($data,200);
    }
    function getNominalRange($input){
        $len = strlen((string)$input);
        $result = "10";
        for ($i=1; $i < $len; $i++) {
            $result .= "0";
        }
        return $result;
    }
}
