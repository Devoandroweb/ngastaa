<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Resources\Master\PayrollTunjanganResource;
use App\Http\Resources\Select\SelectResource;
use App\Models\Master\Payroll\Tunjangan;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PayrollTunjanganContoller extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $tunjangan = Tunjangan::when($search, function ($qr, $search) {
            $qr->where('nama', 'LIKE', "%$search%");
        })
            ->paginate($limit);

        $tunjangan->appends(request()->all());

        $tunjangan = PayrollTunjanganResource::collection($tunjangan);

        // return inertia('Master/Payroll/Tunjangan/index', compact('tunjangan'));
        return view('pages/masterdata/datapayroll/mastertunjangan/index');
    }

    public function json()
    {
        $tunjangan = Tunjangan::orderBy('nama')->where('kode_tunjangan', '!=', 1)->get();
        SelectResource::withoutWrapping();
        $tunjangan = SelectResource::collection($tunjangan);

        return response()->json($tunjangan);
    }

    public function jsonAll()
    {
        $tunjangan = Tunjangan::orderBy('nama')->get();
        SelectResource::withoutWrapping();
        $tunjangan = SelectResource::collection($tunjangan);

        return response()->json($tunjangan);
    }

    public function add()
    {
        $tunjangan = new Tunjangan();
        // return inertia('Master/Payroll/Tunjangan/Add', compact('tunjangan'));
        return view('pages/masterdata/datapayroll/mastertunjangan/add');
    }

    public function edit(Tunjangan $tunjangan)
    {
        // return inertia('Master/Payroll/Tunjangan/Add', compact('tunjangan'));
        return view('pages/masterdata/datapayroll/mastertunjangan/edit', compact('tunjangan'));
    }

    public function delete(Tunjangan $tunjangan)
    {
        $cr = $tunjangan->delete();
        if ($cr) {
            return redirect(route('master.payroll.tunjangan.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('master.payroll.tunjangan.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store()
    {
        $rules = [
            'kode_tunjangan' => 'required',
            'nama' => 'required',
        ];

        if (!request('id')) {
            $rules['kode_tunjangan'] = 'required|unique:ms_tunjangan';
        }

        $data = request()->validate($rules);

        $cr = Tunjangan::updateOrCreate(['id' => request('id')], $data);

        if ($cr) {
            return redirect(route('master.payroll.tunjangan.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil!"
            ]);
        } else {
            return redirect(route('master.payroll.tunjangan.index'))->with([
                'type' => 'error',
                'messages' => "Gagal!"
            ]);
        }
    }
    public function datatable(DataTables $dataTables)
    {
        $model = Tunjangan::orderBy('nama');
        return $dataTables->eloquent($model)
            ->addColumn('opsi', function ($row) {

                $html = "<a class='me-2 edit' tooltip='Edit' href='" . route('master.payroll.tunjangan.edit', $row->id) . "'>" . icons('pencil') . "</a>";
                $html .= "<a class='delete text-danger' tooltip='Hapus' href='" . route('master.payroll.tunjangan.delete', $row->id) . "'>" . icons('trash') . "</a>";
                return $html;
            })
            ->rawColumns(['opsi'])
            ->addIndexColumn()
            ->toJson();
    }
}
