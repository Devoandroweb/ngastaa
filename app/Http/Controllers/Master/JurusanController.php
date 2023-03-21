<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Resources\Master\JurusanResource;
use App\Http\Resources\Select\SelectResource;
use App\Models\Master\Jurusan;
use App\Models\Master\Pendidikan;
use Yajra\DataTables\DataTables;

class JurusanController extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $jurusan = Jurusan::when($search, function ($qr, $search) {
            $qr->where('nama', 'LIKE', "%$search%");
        })
            ->paginate($limit);

        $jurusan->appends(request()->all());

        $jurusan = JurusanResource::collection($jurusan);
        // dd($jurusan);
        // return inertia('Master/Jurusan/index', compact('jurusan'));
        $titlePage = "Data Jurusan"; //wajib
        return view('pages/masterdata/datapendidikan/jurusan/index', compact('titlePage'));
    }

    public function json($pendidikan = null)
    {
        $jurusan = Jurusan::orderBy('nama')
            ->when($pendidikan, function ($qr, $pendidikan) {
                $qr->where('kode_pendidikan', $pendidikan);
            })
            ->get();
        SelectResource::withoutWrapping();
        $jurusan = SelectResource::collection($jurusan);

        return response()->json($jurusan);
    }

    public function add()
    {

        $pendidikan = Pendidikan::all();
        // return inertia('Master/Jurusan/Add', compact('jurusan'));
        return view('pages/masterdata/datapendidikan/jurusan/add', compact('pendidikan'));
    }

    public function edit(Jurusan $jurusan)
    {
        // dd($jurusan);
        // return inertia('Master/Jurusan/Add', compact('jurusan'));
        $pendidikan = Pendidikan::all();

        return view('pages/masterdata/datapendidikan/jurusan/edit', compact('jurusan', 'pendidikan'));
    }

    public function delete(Jurusan $jurusan)
    {
        $cr = $jurusan->delete();
        if ($cr) {
            return redirect(route('master.jurusan.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('master.jurusan.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store()
    {
        $rules = [
            'kode_jurusan' => 'required',
            'kode_pendidikan' => 'required',
            'nama' => 'required',
        ];

        if (!request('id')) {
            $rules['kode_jurusan'] = 'required|unique:jurusan';
        }

        $data = request()->validate($rules);

        $cr = Jurusan::updateOrCreate(['id' => request('id')], $data);

        if ($cr) {
            return redirect(route('master.jurusan.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil!"
            ]);
        } else {
            return redirect(route('master.jurusan.index'))->with([
                'type' => 'error',
                'messages' => "Gagal!"
            ]);
        }
    }
    public function datatable(DataTables $dataTables)
    {
        $model = Jurusan::with('pendidikan');
        return $dataTables->eloquent($model)
            ->addColumn('opsi', function ($row) {

                $html = "<a class='me-2 edit' tooltip='Edit' href='" . route('master.jurusan.edit', $row->id) . "'>" . icons('pencil') . "</a>";
                $html .= "<a class='delete text-danger' tooltip='Hapus' href='" . route('master.jurusan.delete', $row->id) . "'>" . icons('trash') . "</a>";
                return $html;
            })
            ->rawColumns(['opsi'])
            ->addIndexColumn()
            ->toJson();
    }
}
