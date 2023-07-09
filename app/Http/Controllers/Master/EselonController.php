<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Resources\Master\EselonResource;
use App\Http\Resources\Select\SelectResource;
use App\Models\Master\Eselon;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class EselonController extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $eselon = Eselon::when($search, function ($qr, $search) {
            $qr->where('nama', 'LIKE', "%$search%");
        })
            ->paginate($limit);

        $eselon->appends(request()->all());

        $eselon = EselonResource::collection($eselon);

        // return inertia('Master/Eselon/index', compact('eselon'));
        $titlePage = "Data Level Jabatan"; //wajib
        return view('pages/masterdata/datajabatan/leveljabatan/index', compact('titlePage'));
    }

    public function add()
    {
        $eselon = new Eselon();
        // return inertia('Master/Eselon/Add', compact('eselon'));
        return view('pages/masterdata/datajabatan/leveljabatan/add', compact('eselon'));
    }

    public function json()
    {
        $eselon = Eselon::orderBy('nama')->get();
        SelectResource::withoutWrapping();
        $eselon = SelectResource::collection($eselon);

        return response()->json($eselon);
    }


    public function edit(Eselon $eselon)
    {
        // return inertia('Master/Eselon/Add', compact('eselon'));
        return view('pages/masterdata/datajabatan/leveljabatan/edit', compact('eselon'));
    }

    public function reset(Eselon $eselon)
    {
        $cr = $eselon->update([
            'kordinat' => null,
            'latitude' => null,
            'longitude' => null,
            'jarak' => 0,
            'polygon' => null,
        ]);
        if ($cr) {
            return redirect(route('master.eselon.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, direset!"
            ]);
        } else {
            return redirect(route('master.eselon.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, direset!"
            ]);
        }
    }

    public function delete(Eselon $eselon)
    {
        $cr = $eselon->delete();
        if ($cr) {
            return redirect(route('master.eselon.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('master.eselon.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store()
    {
        // dd(request()->all());
        $rules = [
            'kode_eselon' => 'required',
            'nama' => 'required',
            'kordinat' => 'nullable',
            'latitude' => 'nullable',
            'longitude' => 'nullable',
            'jarak' => 'nullable',
            'polygon' => 'nullable',
        ];

        if (!request('id')) {
            $role['name'] = "level_".request('kode_eselon');
            $role['guard_name'] = "web";
            Role::updateOrCreate(['name' => $role['name']], $role);
            $rules['kode_eselon'] = 'required|unique:eselon';
        }
        $data = request()->validate($rules);
        // dd($data);
        $cr = Eselon::updateOrCreate(['id' => request('id')], $data);
        if ($cr) {
            return redirect(route('master.eselon.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil!"
            ]);
        } else {
            return redirect(route('master.eselon.index'))->with([
                'type' => 'error',
                'messages' => "Gagal!"
            ]);
        }
    }
    public function datatable(DataTables $dataTables)
    {
        $model = Eselon::query();
        return $dataTables->eloquent($model)
            ->addColumn('opsi', function ($row) {

                $html = "<a class='me-2 edit' tooltip='Edit' href='" . route('master.eselon.edit', $row->id) . "'>" . icons('pencil') . "</a>";
                $html .= "<a class='delete text-danger' tooltip='Hapus' href='" . route('master.eselon.delete', $row->id) . "'>" . icons('trash') . "</a>";
                return $html;
            })
            ->rawColumns(['opsi'])
            ->addIndexColumn()
            ->toJson();
    }
}
