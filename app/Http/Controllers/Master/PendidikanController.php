<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Resources\Master\PendidikanResource;
use App\Http\Resources\Select\SelectResource;
use App\Models\Master\Pendidikan;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PendidikanController extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $pendidikan = Pendidikan::when($search, function ($qr, $search) {
            $qr->where('nama', 'LIKE', "%$search%");
        })
            ->paginate($limit);

        $pendidikan->appends(request()->all());

        $pendidikan = PendidikanResource::collection($pendidikan);
        // dd($pendidikan);
        // return inertia('Master/Pendidikan/index', compact('pendidikan'));
        return view('pages/masterdata/datapendidikan/tingkatpendidikan/index');
    }

    public function json()
    {
        $pendidikan = Pendidikan::orderBy('nama')->get();
        SelectResource::withoutWrapping();
        $pendidikan = SelectResource::collection($pendidikan);

        return response()->json($pendidikan);
    }

    public function add()
    {
        $pendidikan = new Pendidikan();
        // return inertia('Master/Pendidikan/Add', compact('pendidikan'));
        return view('pages/masterdata/datapendidikan/tingkatpendidikan/add');
    }

    public function edit(Pendidikan $pendidikan)
    {
        // return inertia('Master/Pendidikan/Add', compact('pendidikan'));
        return view('pages/masterdata/datapendidikan/tingkatpendidikan/edit', compact('pendidikan'));
    }

    public function delete(Pendidikan $pendidikan)
    {
        $cr = $pendidikan->delete();
        if ($cr) {
            return redirect(route('master.pendidikan.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('master.pendidikan.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store()
    {
        $rules = [
            'kode_pendidikan' => 'required',
            'nama' => 'required',
        ];

        if (!request('id')) {
            $rules['kode_pendidikan'] = 'required|unique:pendidikan';
        }

        $data = request()->validate($rules);

        $cr = Pendidikan::updateOrCreate(['id' => request('id')], $data);

        if ($cr) {
            return redirect(route('master.pendidikan.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil!"
            ]);
        } else {
            return redirect(route('master.pendidikan.index'))->with([
                'type' => 'error',
                'messages' => "Gagal!"
            ]);
        }
    }
    public function datatable(DataTables $dataTables)
    {
        $model = Pendidikan::query();
        return $dataTables->eloquent($model)
        ->addColumn('opsi', function ($row) {

            $html = "<a class='me-2 edit' tooltip='Edit' href='" . route('master.pendidikan.edit', $row->id) . "'>" . icons('pencil') . "</a>";
            $html .= "<a class='delete text-danger' tooltip='Hapus' href='" . route('master.pendidikan.delete', $row->id) . "'>" . icons('trash') . "</a>";
            return $html;
        })
        ->rawColumns(['opsi'])
        ->addIndexColumn()
        ->toJson();
    }
}
