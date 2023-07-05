<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\Controller;
use App\Http\Resources\Payroll\DataPayrollResource;
use App\Http\Resources\Payroll\GeneratePayrollResource;
use App\Jobs\ProcessGeneratePayroll;
use App\Models\Payroll\DataPayroll;
use App\Models\Payroll\GeneratePayroll;
use App\Models\Payroll\PayrollKurang;
use App\Models\Payroll\PayrollTambah;
use App\Models\User;
use PDF;
use Yajra\DataTables\DataTables;

class GeneratePayrollController extends Controller
{
    public function index()
    {
        return view('pages/payroll/generate/index');
    }

    public function add()
    {
        // return inertia('Payroll/Generate/Add');
        $data = DataPayroll::all();
        $generate = GeneratePayroll::all();
        return view('pages/payroll/generate/add', compact('generate'));
    }

    # Perhitungannya Hamdan (Ruwet)
    // public function store()
    // {
    //     // dd(request()->all());
    //     $bulan = request('bulan') ?? date("m");
    //     $tahun = request('tahun') ?? date("Y");
    //     $kode_skpd = request('kode_skpd');
    //     // dd($kode_skpd);
    //     $kode_payroll = date("YmdHis") . generateRandomString();

    //     $whereNotIn = [];

    //     $qry = GeneratePayroll::where('bulan', $bulan)->where('tahun', $tahun);

    //     $cek = with(clone $qry)->whereNull('kode_skpd')->first();
    //     if ($cek) {
    //         return redirect()->back()->with([
    //             'type' => 'error',
    //             'messages' => "Gagal, Payroll Telah digenerate sebelumnya!"
    //         ]);
    //     }

    //     if ($kode_skpd) {
    //         $skpd = with(clone $qry)->where('kode_skpd', $kode_skpd)->first();
    //         if ($skpd) {
    //             return redirect()->back()->with([
    //                 'type' => 'error',
    //                 'messages' => "Gagal, Payroll Telah digenerate sebelumnya!"
    //             ]);
    //         }
    //     }

    //     $update = with(clone $qry)->first();

    //     if ($update) {
    //         $kode_payroll = $update->kode_payroll;
    //         $whereNotIn = $qry->get()->pluck('kode_skpd')->toArray();
    //     }

    //     GeneratePayroll::updateOrCreate(
    //         [
    //             'kode_payroll' => $kode_payroll,
    //         ],
    //         [
    //             'bulan' => $bulan,
    //             'tahun' => $tahun,
    //             'kode_skpd' => $kode_skpd,
    //         ]
    //     );

    //     $pegawai = User::role('pegawai')
    //         ->when($kode_skpd, function ($qr, $kode_skpd) {
    //             $qr->where('riwayat_jabatan.kode_skpd', $kode_skpd);
    //         })
    //         ->leftJoin('riwayat_jabatan', 'riwayat_jabatan.nip', 'users.nip')
    //         ->where('riwayat_jabatan.is_akhir', 1)
    //         ->whereNotIn('riwayat_jabatan.kode_skpd', $whereNotIn)
    //         ->select('users.nip', 'users.no_hp')
    //         ->get();

    //     foreach ($pegawai as $peg) {
    //         $jabatan = array_key_exists('0', $peg->jabatan_akhir->toArray()) ? $peg->jabatan_akhir[0] : null;
    //         generate_payroll_nip($peg->nip, $peg->no_hp, $jabatan, $kode_payroll, $bulan, $tahun);
    //         // dispatch(new ProcessGeneratePayroll($peg->nip, $peg->no_hp, $jabatan, $kode_payroll, $bulan, $tahun));
    //     }

    //     return redirect()->back()->with([
    //         'type' => 'success',
    //         'messages' => "Berhasil, Pemberitahuan melalui Whatsapp jika payroll berhasil digenerate!"
    //     ]);
    // }
    function store() {
        $bulan = request('bulan') ?? date("m");
        $tahun = request('tahun') ?? date("Y");
        $kode_skpd = request('kode_skpd');
        // dd($kode_skpd);
        $kode_payroll = date("YmdHis") . generateRandomString();

        
    }

    public function regenerate(GeneratePayroll $generate)
    {
        $nip = DataPayroll::where('kode_payroll', $generate->kode_payroll)->where('is_aktif', 0)->pluck('nip')->toArray();

        $pegawai = User::role('pegawai')->whereIn('nip', $nip)->get();
        foreach ($pegawai as $peg) {
            $jabatan = array_key_exists('0', $peg->jabatan_akhir->toArray()) ? $peg->jabatan_akhir[0] : null;
            dispatch(new ProcessGeneratePayroll($peg->nip, $peg->no_hp, $jabatan, $generate->kode_payroll, $generate->bulan, $generate->tahun));
        }

        return redirect()->back()->with([
            'type' => 'success',
            'messages' => "Berhasil, Pemberitahuan melalui Whatsapp jika payroll berhasil digenerate!"
        ]);
    }

    public function delete(GeneratePayroll $generate)
    {
        PayrollTambah::where('kode_payroll', $generate->kode_payroll)->delete();
        PayrollKurang::where('kode_payroll', $generate->kode_payroll)->delete();
        DataPayroll::where('kode_payroll', $generate->kode_payroll)->delete();

        $cr = $generate->delete();
        if ($cr) {
            return redirect(route('payroll.generate.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('payroll.generate.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function detail(GeneratePayroll $generate)
    {

        $search = request('s');
        $limit = request('limit') ?? 10;

        $payroll = DataPayroll::when($search, function ($qr, $search) {
            $qr->where('kode_payroll', 'LIKE', "%$search%");
        })->latest()->get();
        // dd($payroll);
        // $payroll->appends(request()->all());

        // $payroll = DataPayrollResource::collection($payroll);
        // GeneratePayrollResource::withoutWrapping();
        $generate = GeneratePayrollResource::make($generate);
        // dd($generate);
        // return inertia('Payroll/Generate/detail', compact('payroll', 'generate'));
        return view('pages/payroll/generate/detail', compact('generate'));
    }

    public function approved(GeneratePayroll $generate, $payroll = null)
    {
        if ($payroll == null) {
            $cr = DataPayroll::where('kode_payroll', $generate->kode_payroll)->update(['is_aktif', 1]);
            $generate->update(['is_aktif' => 1]);
        } else {
            $cr = DataPayroll::where('kode_payroll', $generate->kode_payroll)->where('id', $payroll)->update(['is_aktif' => 1]);
            $count = DataPayroll::where('kode_payroll', $generate->kode_payroll)->where('is_aktif', 0)->count();
            // dd($count);
            if ($count == 0) {
                $generate->update(['is_aktif' => 1]);
            }
        }

        if ($cr) {
            return redirect()->back()->with([
                'type' => 'success',
                'messages' => "Berhasil, disetujui!"
            ]);
        } else {
            return redirect()->back()->with([
                'type' => 'error',
                'messages' => "Gagal, disetujui!"
            ]);
        }
    }

    public function rejected(GeneratePayroll $generate, $payroll = null)
    {
        if ($payroll == null) {
            $cr = DataPayroll::where('kode_payroll', $generate->kode_payroll)->update(['is_aktif', 0]);
        } else {
            $cr = DataPayroll::where('kode_payroll', $generate->kode_payroll)->where('id', $payroll)->update(['is_aktif' => 0]);
        }
        $generate->update(['is_aktif' => 0]);

        if ($cr) {
            return redirect()->back()->with([
                'type' => 'success',
                'messages' => "Berhasil, dibatalkan!"
            ]);
        } else {
            return redirect()->back()->with([
                'type' => 'error',
                'messages' => "Gagal, dibatalkan!"
            ]);
        }
    }

    public function slip(DataPayroll $dataPayroll)
    {
        $nip = $dataPayroll->nip;
        $kode_payroll = $dataPayroll->kode_payroll;

        $payroll = DataPayroll::where('nip', $nip)->where('kode_payroll', $kode_payroll)->first();
        $penambahan = PayrollTambah::where('nip', $nip)->where('kode_payroll', $kode_payroll)->get();
        $potongan = PayrollKurang::where('nip', $nip)->where('kode_payroll', $kode_payroll)->get();
        // return view('laporan.slipgaji.index',compact('payroll', 'penambahan', 'potongan'));
        $pdf = PDF::loadView('laporan.slipgaji.index', compact('payroll', 'penambahan', 'potongan'))->setPaper('a4', 'potrait');
        return $pdf->stream();
    }
    public function datatable(DataTables $dataTables)
    {
        $model = GeneratePayroll::query();
        // dd($model);
        return $dataTables->eloquent($model)
            ->addColumn('divisi', function ($row) {
                return $row->kode_skpd == "" ? "Semua Divisi Kerja" : get_skpd($row->kode_skpd);
            })
            ->addColumn('bulan', function ($row) {
                return bulan($row->bulan) . " $row->tahun";
            })
            ->addColumn('status', function ($row) {
                return is_aktif($row->is_aktif);
            })
            ->addColumn('opsi', function ($row) {

                $html = "<a class='dropdown-item me-2' href='" . route('payroll.generate.regenerate', $row->id) . "'><i class='dropdown-icon fas fa-recycle'></i><span>Regenerate</span></a>";
                $html .= "<a class='dropdown-item detail text-info' href='" . route('payroll.generate.detail', $row->id) . "'><i class='dropdown-icon fas fa-info-circle'></i><span>Detail</span></a>";
                $html .= "<a class='dropdown-item delete text-danger' href='" . route('payroll.generate.delete', $row->id) . "'><i class='dropdown-icon far fa-trash-alt'></i><span>Delete</span></a>";

                return makeOpsiTable($html);
            })
            ->rawColumns(['opsi', 'status'])
            ->addIndexColumn()
            ->toJson();
    }
    public function payrollDatatable(GeneratePayroll $generate,DataTables $dataTables)
    {
        // dd($generate);
        $payroll = DataPayroll::where("kode_payroll",$generate->kode_payroll)->latest();
        return $dataTables->eloquent($payroll)
                ->addColumn('nama_pegawai', function ($row) {
                    $html = "<span class='badge badge-info'>".$row->nip."</span>";
                    $html .= "<br>".$row->user?->name;
                    return $html;
                })
                ->addColumn('jabatan_divisi', function ($row) {
                    $html = $row->jabatan;
                    $html .= "<br>".$row->divisi;
                    return $html;
                })
                ->addColumn('bulan', function ($row) {
                    return bulan($row->bulan) . " $row->tahun";
                })
                ->addColumn('status', function ($row) {
                    return isActifBagde($row->is_aktif);
                })
                ->editColumn('gaji_pokok', function ($row) {
                    return number_indo($row->gaji_pokok);
                })
                ->editColumn('total_penambahan', function ($row) {
                    return number_indo($row->total_penambahan);
                })
                ->editColumn('total_potongan', function ($row) {
                    return number_indo($row->total_potongan);
                })
                ->editColumn('total', function ($row) {
                    return number_indo($row->total);
                })
                ->addColumn('opsi', function ($row) use ($generate) {
                    if($row->is_aktif == 1){
                        $html = "<a class='dropdown-item approval text-danger me-2' href='" . route('payroll.generate.rejected', [$generate,$row->id]) . "'><i class='dropdown-icon far fa-times-circle'></i><span>Batalkan</span></a>";
                    }else{
                        $html = "<a class='dropdown-item approval text-success me-2' href='" . route('payroll.generate.approved', [$generate,$row->id]) . "'><i class='dropdown-icon fas fa-check'></i><span>Terima</span></a>";
                    }
                    $html .= "<a class='dropdown-item detail text-info' href='" . route('payroll.generate.slip', ['dataPayroll'=>$row]) . "'><i class='dropdown-icon fas fa-book'></i><span>Slip Gaji</span></a>";

                    return makeOpsiTable($html);
                })
                ->rawColumns(['opsi', 'status','nama_pegawai','jabatan_divisi'])
                ->addIndexColumn()
                ->toJson();
    }
}
