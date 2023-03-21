<?php

namespace App\Http\Controllers;

use App\Http\Resources\PengumumanResource;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class PengumumanController extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $pengumuman = Pengumuman::when($search, function ($qr, $search) {
            $qr->where('nama', 'LIKE', "%$search%")->orWhere('kode', 'LIKE', "%$search%");
        })->paginate($limit);
        $pengumuman->appends(request()->all());

        $pengumuman = PengumumanResource::collection($pengumuman);

        // return inertia('Pengumuman/index', compact('pengumuman'));
        return view('pages/pengumuman/index');
    }

    public function edit(Pengumuman $pengumuman)
    {
        // return inertia('Pengumuman/edit', compact('pengumuman'));
        return view('pages/pengumuman/edit', compact('pengumuman'));
    }

    public function add()
    {
        $pengumuman = new Pengumuman();
        // return inertia('Pengumuman/edit', compact('pengumuman'));
        return view('pages/pengumuman/add');
    }


    public function store()
    {
        $data = request()->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
        ]);
        if (request()->file('file')) {
            request()->validate([
                'file' => 'max:2048|mimes:pdf,jpg,jpeg,png',
            ]);
        }

        if (request('id') == '') {
            $data['file'] = request()->file('file') ? request()->file('file')->store('uploads/pengumuman') : '';
            $up = Pengumuman::create($data);
        } else {
            if (request()->file('file')) {
                $data['file'] = request()->file('file')->store('uploads/pengumuman');
            }
            $up = Pengumuman::where('id', request('id'))->update($data);
        }

        if ($up) {
            return redirect(route('pengumuman.index'))->with([
                'type' => 'success',
                'messages' => 'Berhasil!'
            ]);
        } else {
            return redirect(route('pengumuman.index'))->with([
                'type' => 'error',
                'messages' => 'Gagal!'
            ]);
        }
    }

    public function delete(Pengumuman $pengumuman)
    {
        if ($pengumuman->file) {
            Storage::delete($pengumuman->file);
        }
        $pengumuman->delete();
        return redirect(route('pengumuman.index'))->with([
            'type' => 'success',
            'messages' => 'Berhasil!'
        ]);
    }
    public function datatable(DataTables $dataTables)
    {
        $pengumuman = Pengumuman::all();
        // $pengumuman = PengumumanResource::collection($pengumuman);
        // dd(url($pengumuman[0]['file']));
        return $dataTables->of($pengumuman)
            ->addColumn('file', function ($row) {
                return '<a class="btn btn-outline-info btn-animated" href="' . $row->file . '">Lihat File</a>';
            })
            ->addColumn('opsi', function ($row) {

                $html = "<a class='me-2 edit' tooltip='Edit' href='" . route('pengumuman.edit', $row->id) . "'>" . icons('pencil') . "</a>";
                $html .= "<a class='delete text-danger' tooltip='Hapus' href='" . route('pengumuman.delete', $row->id) . "'>" . icons('trash') . "</a>";
                return $html;
            })
            ->rawColumns(['opsi', 'file'])
            ->addIndexColumn()
            ->toJson();
    }
}
