<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Resources\Master\PenghargaanResource;
use App\Http\Resources\Select\SelectResource;
use App\Models\Master\Penghargaan;
use Yajra\DataTables\DataTables;

class PenghargaanController extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $penghargaan = Penghargaan::when($search, function ($qr, $search) {
            $qr->where('nama', 'LIKE', "%$search%");
        })
            ->paginate($limit);

        $penghargaan->appends(request()->all());

        $penghargaan = PenghargaanResource::collection($penghargaan);

        // return inertia('Master/Penghargaan/index', compact('penghargaan'));
        return view('pages/masterdata/datalainya/penghargaan/index');
    }

    public function json()
    {
        $penghargaan = Penghargaan::orderBy('nama')->get();
        SelectResource::withoutWrapping();
        $penghargaan = SelectResource::collection($penghargaan);

        return response()->json($penghargaan);
    }

    public function add()
    {
        $penghargaan = new Penghargaan();
        // return inertia('Master/Penghargaan/Add', compact('penghargaan'));
        return view('pages/masterdata/datalainya/penghargaan/add');
    }

    public function edit(Penghargaan $penghargaan)
    {
        // return inertia('Master/Penghargaan/Add', compact('penghargaan'));
        return view('pages/masterdata/datalainya/penghargaan/edit', compact('penghargaan'));
    }

    public function delete(Penghargaan $penghargaan)
    {
        $cr = $penghargaan->delete();
        if ($cr) {
            return redirect(route('master.penghargaan.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('master.penghargaan.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store()
    {
        $rules = [
            'kode_penghargaan' => 'required',
            'nama' => 'required',
        ];

        if (!request('id')) {
            $rules['kode_penghargaan'] = 'required|unique:penghargaan';
        }

        $data = request()->validate($rules);

        $cr = Penghargaan::updateOrCreate(['id' => request('id')], $data);

        if ($cr) {
            return redirect(route('master.penghargaan.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil!"
            ]);
        } else {
            return redirect(route('master.penghargaan.index'))->with([
                'type' => 'error',
                'messages' => "Gagal!"
            ]);
        }
    }
    public function datatable(DataTables $dataTables)
    {
        $model = Penghargaan::query();
        return $dataTables->eloquent($model)
            ->addColumn('opsi', function ($row) {

                $html = "<a class='me-2 edit' tooltip='Edit' href='" . route('master.penghargaan.edit', $row->id) . "'>" . icons('pencil') . "</a>";
                $html .= "<a class='text-danger delete' tooltip='Edit' href='" . route('master.penghargaan.delete', $row->id) . "'>" . icons('trash') . "</a>";
                return $html;
            })
            ->rawColumns(['opsi'])
            ->addIndexColumn()
            ->toJson();
    }
}
