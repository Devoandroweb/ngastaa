<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Resources\Master\StatusPegawaiResource;
use App\Http\Resources\Select\SelectResource;
use App\Models\Master\StatusPegawai;
use App\Models\User;
use Yajra\DataTables\DataTables;

class StatusPegawaiController extends Controller
{

    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $status_pegawai = StatusPegawai::when($search, function ($qr, $search) {
            $qr->where('nama', 'LIKE', "%$search%");
        })
            ->paginate($limit);

        $status_pegawai->appends(request()->all());

        $status_pegawai = StatusPegawaiResource::collection($status_pegawai);

        // return inertia('Master/StatusPegawai/index', compact('status_pegawai'));

        return view('pages/masterdata/datajabatan/statuspegawai/index');
    }

    public function json()
    {
        $status_pegawai = StatusPegawai::orderBy('nama')->get();
        SelectResource::withoutWrapping();
        $status_pegawai = SelectResource::collection($status_pegawai);

        return response()->json($status_pegawai);
    }

    public function add()
    {
        $status_pegawai = new StatusPegawai();
        // return inertia('Master/StatusPegawai/Add', compact('status_pegawai'));
        return view('pages/masterdata/datajabatan/statuspegawai/add');
    }

    public function edit(StatusPegawai $status_pegawai)
    {
        // return inertia('Master/StatusPegawai/Add', compact('status_pegawai'));
        return view('pages/masterdata/datajabatan/statuspegawai/edit', compact('status_pegawai'));
    }

    public function delete(StatusPegawai $status_pegawai)
    {
        $cr = $status_pegawai->delete();
        if ($cr) {
            return redirect(route('master.status_pegawai.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('master.status_pegawai.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store()
    {
        $rules = [
            'kode_status' => 'required',
            'nama' => 'required',
        ];

        if (!request('id')) {
            $rules['kode_status'] = 'required|unique:status_pegawai';
        }

        $data = request()->validate($rules);
        // dd($data);
        $cr = StatusPegawai::updateOrCreate(['id' => request('id')], $data);

        if ($cr) {
            return redirect(route('master.status_pegawai.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil!"
            ]);
        } else {
            return redirect(route('master.status_pegawai.index'))->with([
                'type' => 'error',
                'messages' => "Gagal!"
            ]);
        }
    }
    public function datatable(DataTables $dataTables)
    {
        $model = StatusPegawai::query();
        return $dataTables->eloquent($model)
            ->addColumn('opsi', function ($row) {

                $html = "<a class='me-2 edit' tooltip='Edit' href='" . route('master.status_pegawai.edit', $row->id) . "'>" . icons('pencil') . "</a>";
                $html .= "<a class='delete text-danger' tooltip='Hapus' href='" . route('master.status_pegawai.delete', $row->id) . "'>" . icons('trash') . "</a>";
                return $html;
            })
            ->rawColumns(['opsi'])
            ->addIndexColumn()
            ->toJson();
    }
}
