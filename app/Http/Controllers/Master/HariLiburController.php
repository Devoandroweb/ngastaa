<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Resources\Master\HariLiburResource;
use App\Models\Master\HariLibur;
use Yajra\DataTables\DataTables;

class HariLiburController extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $hariLibur = HariLibur::when($search, function ($qr, $search) {
            $qr->where('nama', 'LIKE', "%$search%");
        })
            ->paginate($limit);

        $hariLibur->appends(request()->all());

        $hariLibur = HariLiburResource::collection($hariLibur);

        // return inertia('Master/HariLibur/index', compact('hariLibur'));
        $titlePage = "Data Hari Libur"; //wajib
        return view('pages/masterdata/datapresensi/harilibur/index', compact('titlePage'));
    }

    public function add()
    {
        // $hariLibur = new HariLibur();
        // return inertia('Master/HariLibur/Add', compact('hariLibur'));
        return view('pages/masterdata/datapresensi/harilibur/add');
    }

    public function edit(HariLibur $hariLibur)
    {
        // return inertia('Master/HariLibur/Add', compact('hariLibur'));
        return view('pages/masterdata/datapresensi/harilibur/edit', compact('hariLibur'));
    }

    public function delete(HariLibur $hariLibur)
    {
        $cr = $hariLibur->delete();
        if ($cr) {
            return redirect(route('master.hariLibur.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('master.hariLibur.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store()
    {
        $rules = [
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required',
            'nama' => 'required',
        ];

        $data = request()->validate($rules);

        if (strtotime(request('tanggal_mulai')) > strtotime(request('tanggal_selesai'))) {
            return redirect()->back()->with([
                'type' => 'error',
                'messages' => "Gagal, Tanggal mulai harus lebih kecil dari tanggal selesai!"
            ]);
        }

        $cr = HariLibur::updateOrCreate(['id' => request('id')], $data);

        if ($cr) {
            return redirect(route('master.hariLibur.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil!"
            ]);
        } else {
            return redirect(route('master.hariLibur.index'))->with([
                'type' => 'error',
                'messages' => "Gagal!"
            ]);
        }
    }
    public function datatable(DataTables $dataTables)
    {
        $model = HariLibur::query();
        return $dataTables->eloquent($model)
            ->addColumn('tanggal_mulai', function ($row) {
                return tanggal_indo($row->tanggal_mulai);
            })
            ->addColumn('tanggal_selesai', function ($row) {
                return tanggal_indo($row->tanggal_selesai);
            })
            ->addColumn('opsi', function ($row) {

                $html = "<a class='me-2 edit' tooltip='Edit' href='" . route('master.hariLibur.edit', $row->id) . "'>" . icons('pencil') . "</a>";
                $html .= "<a class='delete text-danger' tooltip='Hapus' href='" . route('master.hariLibur.delete', $row->id) . "'>" . icons('trash') . "</a>";
                return $html;
            })
            ->rawColumns(['opsi'])
            ->addIndexColumn()
            ->toJson();
    }
}
