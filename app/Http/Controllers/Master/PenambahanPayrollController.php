<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Resources\Master\PenambahanPayrollResource;
use App\Http\Resources\Select\SelectResource;
use App\Http\Resources\SelectTingkatResource;
use App\Models\Master\Payroll\Tambahan;
use App\Models\Master\Payroll\Tunjangan;
use App\Models\Master\Tingkat;
use Yajra\DataTables\DataTables;

class PenambahanPayrollController extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $tambahan = Tambahan::when($search, function ($qr, $search) {
            $qr->where('nama', 'LIKE', "%$search%");
        })
            ->paginate($limit);

        $tambahan->appends(request()->all());

        $tambahan = PenambahanPayrollResource::collection($tambahan);

        // return inertia('Master/Payroll/Tambahan/index', compact('tambahan'));
        return view('pages/masterdata/datapayroll/komponenpenambahan/index');
    }

    public function json()
    {
        $tambahan = Tambahan::orderBy('nama')->get();
        SelectResource::withoutWrapping();
        $tambahan = SelectResource::collection($tambahan);

        return response()->json($tambahan);
    }

    public function add()
    {
        // $tambahan = new Tambahan();
        $tambahan = Tambahan::all();

        // return inertia('Master/Payroll/Tambahan/Add', compact('tambahan'));
        return view('pages/masterdata/datapayroll/komponenpenambahan/add', compact('tambahan'));
    }

    public function edit(Tambahan $tambahan)
    {
        
        $tunjangan = array_map('trim', explode(',', $tambahan->kode_persen));
        SelectResource::withoutWrapping();
        $tunjangan = SelectResource::collection(Tunjangan::whereIn("kode_tunjangan", $tunjangan)->get());
        // return inertia('Master/Payroll/Tambahan/Add', compact('tambahan'));
        $tunjanganAll = Tunjangan::all();

        return view('pages/masterdata/datapayroll/komponenpenambahan/edit', compact('tambahan', 'tunjanganAll', 'tunjangan'));
    }

    public function delete(Tambahan $tambahan)
    {
        $cr = $tambahan->delete();
        if ($cr) {
            return redirect(route('master.payroll.penambahan.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('master.payroll.penambahan.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store()
    {
        // dd(request()->all());
        $rules = [
            'kode_tambah' => 'required',
            'nama' => 'required',
            'satuan' => 'required',
            'nilai' => 'required',
        ];

        if (!request('id')) {
            $rules['kode_tambah'] = 'required|unique:ms_tambahan';
        }
        if (request('satuan') == '2') {
            $rules['kode_persen'] = 'required';
        }

        $data = request()->validate($rules);

        $kode = [];

        if (!is_null(request('kode_persen'))) {
            foreach (request('kode_persen') as $k) {
                array_push($kode, trim(json_decode($k)->kode_tunjangan));
            }
            $data['kode_persen'] = implode(',', $kode);
        }

        $data['nilai'] = number_to_sql($data['nilai']);

        $cek = false;
        if (!request('id')) {
            $cek = Tambahan::where('kode_tambah', $data['kode_tambah'])->first();
        }

        if ($cek) {
            return redirect(route('master.payroll.penambahan.index'))->with([
                'type' => 'error',
                'messages' => "Kode tidak boleh 1 atau kode telah ada!"
            ]);
        }

        $cr = Tambahan::updateOrCreate(['id' => request('id')], $data);

        if ($cr) {
            return redirect(route('master.payroll.penambahan.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil!"
            ]);
        } else {
            return redirect(route('master.payroll.penambahan.index'))->with([
                'type' => 'error',
                'messages' => "Gagal!"
            ]);
        }
    }
    public function datatable(DataTables $dataTables)
    {
        $model = Tambahan::query();
        return $dataTables->eloquent($model)
            ->addColumn('nilai', function ($row) {
                return number_indo($row->nilai) . " (" . satuan($row->satuan) . ") <br> <b class='text-success'>" . ($row->satuan == 2 ? master_tunjangan($row->kode_persen) : "") . '<b>';
            })
            ->addColumn('opsi', function ($row) {

                $html = "<a class='me-2 edit' tooltip='Edit' href='" . route('master.payroll.penambahan.edit', $row->id) . "'>" . icons('pencil') . "</a>";
                $html .= "<a class='delete text-danger' tooltip='Hapus' href='" . route('master.payroll.penambahan.delete', $row->id) . "'>" . icons('trash') . "</a>";
                return $html;
            })
            ->rawColumns(['opsi', 'nilai'])
            ->addIndexColumn()
            ->toJson();
    }
}
