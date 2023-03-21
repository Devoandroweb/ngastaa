<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\Controller;
use App\Http\Resources\Payroll\TambahPayrollResource;
use App\Http\Resources\SelectTingkatResource;
use App\Models\Master\Tingkat;
use App\Models\Payroll\DaftarTambahPayroll;
use Yajra\DataTables\DataTables;

class TambahPayrollController extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $tambah = DaftarTambahPayroll::latest()->paginate($limit);

        $tambah->appends(request()->all());
        $tambah = TambahPayrollResource::collection($tambah);
        // return inertia('Payroll/Tambah/index', compact('tambah'));
        return view('pages/payroll/daftarpenambahan/index', compact('tambah'));
    }

    public function add()
    {
        $tambah = new DaftarTambahPayroll();
        $tingkat = Tingkat::with(str_repeat('children.', 99))->whereNull('parent_id')->get();
        // SelectTingkatResource::withoutWrapping();
        // $parent = SelectTingkatResource::collection($parent);
        // return inertia('Payroll/Tambah/Add', compact('tambah', 'parent'));
        return view('pages/payroll/daftarpenambahan/add', compact('tambah', 'tingkat'));
    }

    public function edit(DaftarTambahPayroll $tambah)
    {
        // dd(\App\Models\User::role('pegawai')->orderBy('name')->get());
        $tingkat = Tingkat::with(str_repeat('children.', 99))->whereNull('parent_id')->get();
        // SelectTingkatResource::withoutWrapping();
        // $parent = SelectTingkatResource::collection($parent);
        // return inertia('Payroll/Tambah/Add', compact('tambah', 'parent'));
        return view('pages/payroll/daftarpenambahan/edit', compact('tambah', 'tingkat'));
    }

    public function delete(DaftarTambahPayroll $tambah)
    {
        $cr = $tambah->delete();
        if ($cr) {
            return redirect(route('payroll.tambah.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('payroll.tambah.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store()
    {
        $rules = [
            'kode_tambah' => 'required',
            'bulan' => 'nullable',
            'tahun' => 'nullable',
            'is_periode' => 'required',
            'keterangan' => 'required',
            'kode_keterangan' => 'nullable',
        ];

        $data = request()->validate($rules);

        if (request('is_periode') == 1) {
            if (request('bulan') == null) {
                $data['bulan'] = date('m');
            }
            if (request('tahun') == null) {
                $data['tahun'] = date('Y');
            }
        }

        $kode = [];
        if (request('keterangan') == 1) {
            foreach (request('kode_keterangan') as $k) {
                array_push($kode, trim(json_decode($k)->nip));
            }

            $data['kode_keterangan'] = implode(',', $kode);
        }
        if (request('keterangan') == 2) {
            $data['kode_keterangan'] = json_decode($data['kode_keterangan'])->kode_tingkat;
        }
        if (request('keterangan') == 3) {
            $data['kode_keterangan'] = json_decode($data['kode_keterangan'])->kode_eselon;
        }
        if (request('keterangan') == 4) {
            $data['kode_keterangan'] = json_decode($data['kode_keterangan'])->kode_skpd;
        }
        if (request('keterangan') == 'semua') {
            $data['kode_keterangan'] = "";
        }

        $id = request('id');

        $cr = DaftarTambahPayroll::updateOrCreate(
            [
                'id' => $id,
            ],
            $data
        );

        if ($cr) {
            return redirect(route('payroll.tambah.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, diperbaharui!"
            ]);
        } else {
            return redirect(route('payroll.tambah.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, diperbaharui!"
            ]);
        }
    }
    public function datatable(DataTables $dataTables)
    {
        $tambah = DaftarTambahPayroll::get();
        $tambah = TambahPayrollResource::collection($tambah);
        return $dataTables->of($tambah)
            ->addColumn('detail', function ($row) {
                return detail_keterangan($row->keterangan, $row->kode_keterangan);
            })
            ->addColumn('keterangan', function ($row) {
                return keterangan($row->keterangan);
            })
            ->addColumn('tanggal', function ($row) {
                return $row->is_periode == 1 ? bulan($row->bulan) . " / " . $row->tahun : "Selamanya";
            })
            ->addColumn('nama', function ($row) {
                return $row->tambah?->nama;
            })
            ->addColumn('opsi', function ($row) {

                $html = "<a class='me-2 edit' tooltip='Edit' href='" . route('payroll.tambah.edit', $row->id) . "'>" . icons('pencil') . "</a>";
                $html .= "<a class='text-danger delete' tooltip='Hapus' href='" . route('payroll.tambah.delete', $row->id) . "'>" . icons('trash') . "</a>";
                return $html;
            })
            ->rawColumns(['opsi'])
            ->addIndexColumn()->toJson();
    }
}
