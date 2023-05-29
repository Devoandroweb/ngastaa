<?php

namespace App\Http\Controllers\Pegawai;

use App\Exports\Laporan\LaporanDivisiExport;
use App\Exports\Laporan\LaporanPegawaiExport;
use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\DataPresensiResource;
use App\Models\Master\Lokasi;
use App\Models\Master\Skpd;
use App\Models\Master\Visit;
use App\Models\Pegawai\DataPresensi;
use App\Models\Pegawai\DataVisit;
use App\Models\User;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class DataPresensiController extends Controller
{
    public function index()
    {
        $date = request('d') ?? date('Y-m-d', strtotime('-1 days'));
        $end = request('e') ?? date('Y-m-d');
        if (strtotime($end) <= strtotime($date)) {
            return redirect()->back()->with([
                'type' => 'error',
                'messages' => 'Tanggal Akhir tidak boleh lebih besar atau sama dengan tanggal awal!'
            ]);
        }
        $search = request('s');
        $kode = request('kode');
        $limit = request('limit') ?? 10;

        $end = date('Y-m-d', (strtotime($end) + (60 * 60 * 24)));

        $role = role('opd');

        $qr = DataPresensi::selectRaw("data_presensi.id as id, users.name as nama, users.nip as nip, data_presensi.tanggal_datang, data_presensi.tanggal_istirahat, data_presensi.tanggal_pulang, data_presensi.created_at, tingkat.nama as jabatan")
            ->leftJoin('users', 'users.nip', 'data_presensi.nip')
            ->leftJoin('tingkat', 'tingkat.kode_tingkat', 'data_presensi.kode_tingkat')
            ->when($search, function ($qr, $search) {
                $qr->where('data_presensi.nip', 'LIKE', "%$search%")
                    ->orWhere('users.name', 'LIKE', "%$search%")
                    ->orWhere('tingkat.nama', 'LIKE', "%$search%");
            })
            ->when($kode, function ($qr, $kode) {
                $qr->where('tingkat.kode_skpd', $kode);
            })
            ->when($role, function ($qr) {
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
            })
            ->whereBetween('data_presensi.created_at', [$date, $end])
            ->paginate($limit);

        $qr->appends(request()->all());


        $presensi = DataPresensiResource::collection($qr);
        $lokasiKerja = Lokasi::select('nama','polygon')->get();
        $dataLokasi = [];
        foreach ($lokasiKerja as $lokasi) {
            $dataPolygon = [];
            $polygon = json_decode($lokasi->polygon);
            // dd($polygon);
            // die();
            if($polygon != null){
                // dd("ada");
                foreach ($polygon[0] as $gon) {
                    $dataPolygon[] = [$gon->lng,$gon->lat];
                    // dd($gon);
                }
            }
            $dataLokasi[] = ['nama'=>$lokasi->nama,'polygon'=>$dataPolygon,'polygonAsli'=>$lokasi->polygon];
;        }
        // dd($dataLokasi);
        $skpd = Skpd::all();

        return view('pages/daftarpresensi/dataharian/index',compact('lokasiKerja','dataLokasi','skpd'));
    }

    public function laporan_pegawai()
    {
        // return inertia('Presensi/LaporanPegawai');
        return view('pages/daftarpresensi/laporanpegawai/add');
    }

    public function laporan_pegawai_download()
    {
        $bulan = request('bulan') ?? date('m');
        $tahun = request('tahun') ?? date('Y');
        $nip = request('pegawai');
        $xl = request('xl');
        // dd($xl);
        $role = role('opd');
        $pegawai = User::where('nip', $nip)
            ->when($role, function ($qr) {
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
            })
            ->first();
        // dd($pegawai);
        if($pegawai == null){
            return redirect()->back()->with([
                'type' => 'error',
                'messages' => 'Data Laporan tidak di temukan'
            ]);
        }else{
            if ($xl == "true") {
                $date = date("YmdHis");
                $response = Excel::download(new LaporanPegawaiExport($bulan, $tahun, $xl, $pegawai), "pegawai-$nip-$date.xlsx", \Maatwebsite\Excel\Excel::XLSX);
                ob_end_clean();
                return $response;
                // return view('laporan.presensi.pegawai', compact('bulan', 'xl', 'tahun', 'pegawai'));
            } else {
                $pdf = PDF::loadView('laporan.presensi.pegawai', compact('bulan', 'xl', 'tahun', 'pegawai'))->setPaper('a4', 'potrait');
                // ob_end_clean();
                return $pdf->stream();
            }
        }
    }

    public function laporan_divisi()
    {
        // return inertia('Presensi/LaporanDivisi');
        return view('pages/daftarpresensi/laporandivisi/add');
    }

    public function laporan_divisi_download()
    {
        $bulan = request('bulan') ?? date('m');
        $tahun = request('tahun') ?? date('Y');
        $kode = request('kode');
        $xl = request('xl');
        $role = role('opd');

        $presensi = DataPresensi::where('kode_tingkat', $kode)
            ->select('nip')
            ->whereMonth('created_at', $bulan)
            ->groupBy('nip')
            ->pluck('nip')
            ->toArray();

        $pegawai = User::whereIn('nip', $presensi)
            ->when($role, function ($qr) {
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
            })
            ->get();
        if($pegawai == null){
            return redirect()->back()->with([
                'type' => 'error',
                'messages' => 'Data Laporan tidak di temukan'
            ]);
        }else{
            if ($xl) {
                $date = date("YmdHis");
                return Excel::download(new LaporanDivisiExport($bulan, $tahun, $kode, $pegawai), "pegawai-$kode-$date.xlsx");
                // return view('laporan.presensi.divisi-xls', compact('bulan', 'tahun', 'pegawai', 'kode'));
            } else {
                $pdf = PDF::loadView('laporan.presensi.divisi', compact('bulan', 'tahun', 'pegawai', 'kode'))->setPaper('a4', 'landscape');
                return $pdf->stream();
            }
        }
    }
    public function datatable(DataTables $dataTables)
    {
        $skpd = request()->query('skpd');
        $skpd = ($skpd == 0) ? null : $skpd;
        $role = role('opd');

        // $skpd = 1;
        $model = DataPresensi::selectRaw("data_presensi.id as id, users.name as nama, users.nip as nip, data_presensi.tanggal_datang, data_presensi.tanggal_istirahat, data_presensi.tanggal_pulang, data_presensi.created_at, tingkat.nama as jabatan, data_presensi.kordinat_datang, data_presensi.foto_datang, shift.nama as nama_shift")
            ->leftJoin('users', 'users.nip', 'data_presensi.nip')
            ->leftJoin('tingkat', 'tingkat.kode_tingkat', 'data_presensi.kode_tingkat')
            ->leftJoin('shift', 'shift.kode_shift', 'data_presensi.kode_shift');
        // dd($model->get());
        if($skpd){
            // dd($skpd);
            $model->where('tingkat.kode_skpd', $skpd);
        }
        $model->when($role, function ($qr) {
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
        });
        // dd($model->get()[0]);
        return $dataTables->of($model)
            ->editColumn('shift', function ($row) {
                return $row->nama_shift;
            })
            ->addColumn('nama_original', function ($row) {
                return $row->nama;
            })
            ->addColumn('nama', function ($row) {
                return "<span class='badge badge-success badge-pill badge-sm'>". $row->nip . "</span>  " . $row->nama;
            })
            ->addColumn('jabatan', function ($row) {
                dd($row->riwayat_jabatan);
                return $row->riwayat_jabatan;
            })
            ->addColumn('tanggal', function ($row) {
                return tanggal_indo($row->created_at);
            })
            ->addColumn('jam_datang', function ($row) {
                return get_jam($row->tanggal_datang);
            })
            ->addColumn('jam_istirahat', function ($row) {
                return get_jam($row->jam_istirahat);
            })
            ->addColumn('jam_pulang', function ($row) {
                return get_jam($row->tanggal_pulang);
            })
            ->rawColumns(['nama'])
            ->addIndexColumn()
            ->toJson();
    }
}
