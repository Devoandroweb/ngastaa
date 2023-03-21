<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Resources\Master\KursusResource;
use App\Http\Resources\Select\SelectResource;
use App\Models\Master\Kursus;
use Yajra\DataTables\DataTables;


class KursusController extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $kursus = Kursus::when($search, function ($qr, $search) {
            $qr->where('nama', 'LIKE', "%$search%");
        })
            ->paginate($limit);

        $kursus->appends(request()->all());

        $kursus = KursusResource::collection($kursus);

        // return inertia('Master/Kursus/index', compact('kursus'));

        return view('pages/masterdata/datapendidikan/kursuspelatihan/index');
    }

    public function json()
    {
        $kursus = Kursus::orderBy('nama')->get();
        SelectResource::withoutWrapping();
        $kursus = SelectResource::collection($kursus);

        return response()->json($kursus);
    }

    public function add()
    {
        $kursus = new Kursus();
        // return inertia('Master/Kursus/Add', compact('kursus'));
        return view('pages/masterdata/datapendidikan/kursuspelatihan/add');
    }

    public function edit(Kursus $kursus)
    {
        // return inertia('Master/Kursus/Add', compact('kursus'));
        return view('pages/masterdata/datapendidikan/kursuspelatihan/edit', compact('kursus'));
    }

    public function delete(Kursus $kursus)
    {
        $cr = $kursus->delete();
        if ($cr) {
            return redirect(route('master.kursus.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('master.kursus.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store()
    {
        $rules = [
            'kode_kursus' => 'required',
            'nama' => 'required',
        ];

        if (!request('id')) {
            $rules['kode_kursus'] = 'required|unique:kursus';
        }

        $data = request()->validate($rules);

        $cr = Kursus::updateOrCreate(['id' => request('id')], $data);

        if ($cr) {
            return redirect(route('master.kursus.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil!"
            ]);
        } else {
            return redirect(route('master.kursus.index'))->with([
                'type' => 'error',
                'messages' => "Gagal!"
            ]);
        }
    }

    public function datatable(DataTables $dataTables)
    {
        $model = Kursus::query();
        return $dataTables->eloquent($model)
            ->addColumn('opsi', function ($row) {

                $html = "<a class='me-2 edit' tooltip='Edit' href='" . route('master.kursus.edit', $row->id) . "'>" . icons('pencil') . "</a>";
                $html .= "<a class='delete text-danger' tooltip='Hapus' href='" . route('master.kursus.delete', $row->id) . "'>" . icons('trash') . "</a>";
                return $html;
            })
            ->rawColumns(['opsi'])
            ->addIndexColumn()
            ->toJson();
    }
}
