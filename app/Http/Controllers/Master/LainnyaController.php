<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Resources\Master\LainnyaResource;
use App\Http\Resources\Select\SelectResource;
use App\Models\Master\Lainnya;
use Yajra\DataTables\DataTables;

class LainnyaController extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $lainnya = Lainnya::when($search, function ($qr, $search) {
            $qr->where('nama', 'LIKE', "%$search%");
        })
            ->paginate($limit);

        $lainnya->appends(request()->all());

        $lainnya = LainnyaResource::collection($lainnya);

        // return inertia('Master/Lainnya/index', compact('lainnya'));
        return view('pages/masterdata/datalainya/riwayatlainya/index');
    }

    public function json()
    {
        $lainnya = Lainnya::orderBy('nama')->get();
        SelectResource::withoutWrapping();
        $lainnya = SelectResource::collection($lainnya);

        return response()->json($lainnya);
    }

    public function add()
    {
        $lainnya = new Lainnya();
        // return inertia('Master/Lainnya/Add', compact('lainnya'));
        return view('pages/masterdata/datalainya/riwayatlainya/add');
    }

    public function edit(Lainnya $lainnya)
    {
        // return inertia('Master/Lainnya/Add', compact('lainnya'));
        return view('pages/masterdata/datalainya/riwayatlainya/edit', compact('lainnya'));
    }

    public function delete(Lainnya $lainnya)
    {
        $cr = $lainnya->delete();
        if ($cr) {
            return redirect(route('master.lainnya.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('master.lainnya.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store()
    {
        $rules = [
            'kode_lainnya' => 'required',
            'nama' => 'required',
        ];

        if (!request('id')) {
            $rules['kode_lainnya'] = 'required|unique:lainnya';
        }

        $data = request()->validate($rules);

        $cr = Lainnya::updateOrCreate(['id' => request('id')], $data);

        if ($cr) {
            return redirect(route('master.lainnya.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil!"
            ]);
        } else {
            return redirect(route('master.lainnya.index'))->with([
                'type' => 'error',
                'messages' => "Gagal!"
            ]);
        }
    }
    public function datatable(DataTables $dataTables)
    {
        $model = Lainnya::query();
        return $dataTables->eloquent($model)
            ->addColumn('opsi', function ($row) {

                $html = "<a class='me-2 edit' tooltip='Edit' href='" . route('master.lainnya.edit', $row->id) . "'>" . icons('pencil') . "</a>";
                $html .= "<a class='delete text-danger' tooltip='Hapus' href='" . route('master.lainnya.delete', $row->id) . "'>" . icons('trash') . "</a>";
                return $html;
            })
            ->rawColumns(['opsi'])
            ->addIndexColumn()
            ->toJson();
    }
}
