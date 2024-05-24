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
use App\Models\Presensi\TotalPresensiDetail;
use App\Models\User;
use App\Repositories\Pdf\PdfRepository;
use App\Repositories\Pegawai\PegawaiRepository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;
use Response;
class DataPresensiController extends Controller
{
    protected $pegawaiRepository;
    protected $pdfRepository;
    function __construct(
        PegawaiRepository $pegawaiRepository,
        PdfRepository $pdfRepository,
    ){
        $this->pdfRepository = $pdfRepository;
        $this->pegawaiRepository = $pegawaiRepository;
    }
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
        // dd($nip);
        $pegawai = $this->pegawaiRepository->getFirstPegawai($nip);
        $mJamKerja = $pegawai->jamKerja->where('is_akhir',1)->first()?->jamKerja;
        $jamKerja = $mJamKerja?->hariJamKerja;
        // dd($jamKerja);
        if(!$jamKerja){
            $jamKerja = $pegawai->shift->where('is_akhir',1)->first()?->shift;
        }
        if($jamKerja == null){
            return redirect()->back()->with([
                'type' => 'error',
                'messages' => 'Jam Kerja atau Shift tidak di temukan'
            ]);
        }
        if($pegawai == null){
            return redirect()->back()->with([
                'type' => 'error',
                'messages' => 'Data Laporan tidak di temukan'
            ]);
        }else{
            if ($xl == 1) {
                $date = date("YmdHis");
                $response = Excel::download(new LaporanPegawaiExport($bulan, $tahun, $xl, $pegawai,$jamKerja), "pegawai-$nip-$date.xlsx", \Maatwebsite\Excel\Excel::XLSX);
                ob_end_clean();
                return $response;
                // return view('laporan.presensi.pegawai', compact('bulan', 'xl', 'tahun', 'pegawai'));
            } else {
                $pdf = $this->pdfRepository->generatePresesiSebulan($bulan, $xl, $tahun, $pegawai, $jamKerja, $mJamKerja);
                // $pdf = PDF::loadView('laporan.presensi.pegawai', compact('bulan', 'xl', 'tahun', 'pegawai'))->setPaper('a4', 'potrait');
                ob_end_clean();
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

        $presensi = TotalPresensiDetail::where('kode_tingkat', $kode)
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

        if(!Cache::get("presensi-insert-status")){
            DataPresensi::whereDate("created_at",date("Y-m-d"))->forceDelete();
            $datas = getPresensi();
            DataPresensi::insert($datas);
        }
        // $skpd = 1;
        $model = DataPresensi::selectRaw("data_presensi.id as id, users.name as nama, users.nip as nip, data_presensi.tanggal_datang, data_presensi.tanggal_pulang, data_presensi.created_at, tingkat.nama as jabatan, data_presensi.kordinat_datang, data_presensi.foto_datang, data_presensi.kordinat_pulang, data_presensi.foto_pulang, shift.nama as nama_shift, m_jam_kerja.nama as nama_jam_kerja")
            ->leftJoin('users', 'users.nip', 'data_presensi.nip')
            ->leftJoin('tingkat', 'tingkat.kode_tingkat', 'data_presensi.kode_tingkat')
            ->leftJoin('shift', 'shift.kode_shift', 'data_presensi.kode_shift')
            ->leftJoin('m_jam_kerja', 'm_jam_kerja.kode', 'data_presensi.kode_jam_kerja')
            ->whereDate('data_presensi.created_at',date("Y-m-d"));
        if($skpd){
            $model->whereHas('user',function($q)use($skpd){
                $q->whereHas('riwayat_jabatan',function ($q)use($skpd){
                    $q->where('kode_skpd',$skpd);
                });
            });
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

        return $dataTables->of($model)
            ->editColumn('shift', function ($row) {
                return ($row->nama_shift ?? $row->nama_jam_kerja) ?? "-";
            })
            ->addColumn('nama_original', function ($row) {
                return $row->nama;
            })
            ->addColumn('nama', function ($row) {
                return "<span class='badge badge-success badge-pill badge-sm'>". $row->nip . "</span>  " . $row->nama;
            })
            ->addColumn('jabatan', function ($row) {
                $jabatan_akhir = $row->user?->jabatan_akhir;
                $jabatan = null;
                if(!is_null($jabatan_akhir)){
                    $jabatan = $jabatan_akhir->where('is_akhir',1)->first();
                }

                $nama_jabatan = '-';
                if ($jabatan) {
                    $tingkat = $jabatan?->tingkat;
                    $nama_jabatan =  $tingkat?->nama;
                }
                return $nama_jabatan;
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
    public function generate_laporan_pegawai()
    {
        $bulan = request('bulan') ?? date('m');
        $tahun = request('tahun') ?? date('Y');
        $nip = request('pegawai');
        $xl = request('xl');

        $pegawai = $this->pegawaiRepository->getFirstPegawai($nip);
        $mJamKerja = $pegawai->jamKerja->where('is_akhir',1)->first()?->jamKerja;
        $jamKerja = $mJamKerja?->hariJamKerja;
        // dd($jamKerja);
        if(!$jamKerja){
            $jamKerja = $pegawai->shift->where('is_akhir',1)->first()?->shift;
        }
        if($jamKerja == null){
            return response()->json([
                'status' => false,
                'messages' => 'Jam Kerja atau Shift tidak di temukan'
            ]);
        }
        if($pegawai == null){
            return response()->json([
                'status' => false,
                'messages' => 'Data Laporan tidak di temukan'
            ]);
        }
        try {
            //code...
            $pdf = $this->pdfRepository->generatePresesiSebulan($bulan, $xl, $tahun, $pegawai,$jamKerja,$mJamKerja);

            $pdfLocation = 'show-pdf/presensi-pegawai.pdf';
            if(Storage::fileExists($pdfLocation)){
                Storage::delete($pdfLocation);
            }
            $pdf->save(storage_path($pdfLocation));

            return response()->json([
                'status' => true,
                'messages' => 'Data Laporan di temukan',
                'file' => storage_path($pdfLocation)
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status' => false,
                'messages' => $th->getMessage()
            ]);
        }
    }
    function showPdf(){
        $path = request()->query('path');
        return response()->file($path);
    }

}
