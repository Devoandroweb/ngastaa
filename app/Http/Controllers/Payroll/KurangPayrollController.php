<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\Controller;
use App\Http\Resources\Payroll\KurangPayrollResource;
use App\Http\Resources\SelectTingkatResource;
use App\Models\Master\Tingkat;
use App\Models\Payroll\DaftarKurangPayroll;
use Yajra\DataTables\DataTables;

class KurangPayrollController extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $kurang = DaftarKurangPayroll::latest()->paginate($limit);

        $kurang->appends(request()->all());
        $kurang = KurangPayrollResource::collection($kurang);
        // dd($kurang);
        // return inertia('Payroll/Kurang/index', compact('kurang'));
        return view('pages/payroll/daftarpengurangan/index');
    }

    public function add()
    {
        // $kurang = new DaftarKurangPayroll();
        $tingkat = Tingkat::with(str_repeat('children.', 99))->whereNull('parent_id')->get();
        // SelectTingkatResource::withoutWrapping();
        // $parent = SelectTingkatResource::collection($parent);
        // return inertia('Payroll/Kurang/Add', compact('kurang', 'parent'));
        return view('pages/payroll/daftarpengurangan/add', compact('tingkat'));
    }

    public function edit(DaftarKurangPayroll $kurang)
    {
        // dd($kurang);
        $tingkat = Tingkat::with(str_repeat('children.', 99))->whereNull('parent_id')->get();
        // SelectTingkatResource::withoutWrapping();
        // $parent = SelectTingkatResource::collection($parent);
        // return inertia('Payroll/Kurang/Add', compact('kurang', 'parent'));
        return view('pages/payroll/daftarpengurangan/edit', compact('kurang', 'tingkat'));
    }

    public function delete(DaftarKurangPayroll $kurang)
    {
        $cr = $kurang->delete();
        if ($cr) {
            return redirect(route('payroll.kurang.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('payroll.kurang.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store()
    {
        $rules = [
            'kode_kurang' => 'required',
            'bulan' => 'nullable',
            'tahun' => 'nullable',
            'is_periode' => 'required',
            'keterangan' => 'required',
            'kode_keterangan' => 'nullable',
        ];

        $data = request()->validate($rules);
        // dd($data);

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
        $cr = DaftarKurangPayroll::updateOrCreate(
            [
                'id' => $id,
            ],
            $data
        );

        if ($cr) {
            return redirect(route('payroll.kurang.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, diperbaharui!"
            ]);
        } else {
            return redirect(route('payroll.kurang.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, diperbaharui!"
            ]);
        }
    }
    public function datatable(DataTables $dataTables)
    {
        $kurang = DaftarKurangPayroll::get();
        $kurang = KurangPayrollResource::collection($kurang);
        return $dataTables->of($kurang)
            ->addColumn('detail', function ($row) {
                return detail_keterangan($row->keterangan, $row->kode_keterangan);
            })
            ->addColumn('keterangan', function ($row) {
                return keterangan($row->keterangan);
            })
            ->addColumn('tanggal', function ($row) {
                return $row->is_periode == 1 ? bulan($row->bulan) . " / " . $row->tahun : "Selamanya";
            })
            ->addColumn('kurang', function ($row) {
                return $row->kurang?->nama;
            })
            ->addColumn('opsi', function ($row) {

                $html = "<a class='me-2 edit' tooltip='Edit' href='" . route('payroll.kurang.edit', $row['id']) . "'>" . icons('pencil') . "</a>";
                $html .= "<a class='text-danger delete' tooltip='Hapus' href='" . route('payroll.kurang.delete', $row['id']) . "'>" . icons('trash') . "</a>";
                return $html;
            })
            ->rawColumns(['opsi'])
            ->addIndexColumn()->toJson();
    }
}
