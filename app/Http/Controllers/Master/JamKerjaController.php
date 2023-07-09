<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Master\JamKerjaResource;
use App\Http\Resources\Select\SelectResource;
use App\Models\MJamKerja;
use Yajra\DataTables\DataTables;

class JamKerjaController extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $jamKerja = MJamKerja::when($search, function ($qr, $search) {
            $qr->where('nama', 'LIKE', "%$search%");
        })
            ->paginate($limit);

        $jamKerja->appends(request()->all());

        $jamKerja = JamKerjaResource::collection($jamKerja);

        // return inertia('Master/MJamKerja/index', compact('jam_kerja'));

        return view('pages/masterdata/datapresensi/jam_kerja/index');
    }

    public function json()
    {
        $jamKerja = MJamKerja::orderBy('nama')->get();
        SelectResource::withoutWrapping();
        $jamKerja = SelectResource::collection($jamKerja);

        return response()->json($jamKerja);
    }
    public function json_all()
    {
        $jamKerja = MJamKerja::all();
        return response()->json($jamKerja);
    }

    public function add()
    {
        $jamKerja = null;
        $for = 0;
        // return inertia('Master/MJamKerja/Add', compact('jam_kerja'));
        return view('pages.masterdata.datapresensi.jam_kerja.add', compact('jamKerja','for'));
    }

    public function edit(MJamKerja $jamKerja)
    {
        // return inertia('Master/MJamKerja/Add', compact('jam_kerja'));
        $for = 1;
        return view('pages.masterdata.datapresensi.jam_kerja.add', compact('jamKerja','for'));
    }

    public function delete(MJamKerja $jamKerja)
    {
        $cr = $jamKerja->delete();
        if ($cr) {
            return redirect(route('master.jam_kerja.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('master.jam_kerja.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store()
    {
        // dd(request()->all());
        $rules = [
            'kode' => 'required',
            'nama' => 'required',
            'jam_buka_datang' => 'required',
            'jam_tepat_datang' => 'required',
            'jam_tutup_datang' => 'required',
            'toleransi_datang' => 'nullable',
            'jam_buka_istirahat' => 'nullable',
            'jam_tepat_istirahat' => 'nullable',
            'jam_tutup_istirahat' => 'nullable',
            'toleransi_istirahat' => 'nullable',
            'jam_buka_pulang' => 'required',
            'jam_tepat_pulang' => 'required',
            'jam_tutup_pulang' => 'required',
            'toleransi_pulang' => 'nullable',
        ];

        if (!request('id')) {
            $rules['kode'] = 'required|unique:m_jam_kerja';
        }

        $data = request()->validate($rules);

        $cr = MJamKerja::updateOrCreate(['id' => request('id')], $data);

        if ($cr) {
            return redirect(route('master.jam_kerja.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil!"
            ]);
        } else {
            return redirect(route('master.jam_kerja.index'))->with([
                'type' => 'error',
                'messages' => "Gagal!"
            ]);
        }
    }
    public function datatable(DataTables $dataTables)
    {
        $model = MJamKerja::query();
        return $dataTables->eloquent($model)
            ->addColumn('toleransi_istirahat', function ($row) {
                return $row->toleransi_istirahat . " m";
            })
            ->addColumn('toleransi_pulang', function ($row) {
                return $row->toleransi_pulang . " m";
            })
            ->addColumn('toleransi_datang', function ($row) {
                return $row->toleransi_datang . " m";
            })
            ->addColumn('opsi', function ($row) {
                $html = "";
                if(getPermission('masterDataJamKerja','U')){
                    $html .= "<a class='me-2 edit' tooltip='Edit' href='" . route('master.jam_kerja.edit', $row->id) . "'>" . icons('pencil') . "</a>";
                }
                if(getPermission('masterDataJamKerja','D')){
                    $html .= "<a class='delete text-danger' tooltip='Hapus' href='" . route('master.jam_kerja.delete', $row->id) . "'>" . icons('trash') . "</a>";
                }
                if($html == ""){
                    return "-";
                }
                return $html;
            })
            ->rawColumns(['opsi'])
            ->addIndexColumn()
            ->toJson();
    }
}
