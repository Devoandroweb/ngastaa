<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Resources\Master\ShiftResource;
use App\Http\Resources\Select\SelectResource;
use App\Models\Master\Shift;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ShiftController extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $shift = Shift::when($search, function ($qr, $search) {
            $qr->where('nama', 'LIKE', "%$search%");
        })
            ->paginate($limit);

        $shift->appends(request()->all());

        $shift = ShiftResource::collection($shift);

        // return inertia('Master/Shift/index', compact('shift'));

        return view('pages/masterdata/datapresensi/shift/index');
    }

    public function json()
    {
        $shift = Shift::orderBy('nama')->get();
        SelectResource::withoutWrapping();
        $shift = SelectResource::collection($shift);

        return response()->json($shift);
    }
    public function json_all()
    {
        $shift = Shift::all();
        return response()->json($shift);
    }

    public function add()
    {
        $shift = null;
        $for = 0;
        // return inertia('Master/Shift/Add', compact('shift'));
        return view('pages.masterdata.datapresensi.shift.add', compact('shift','for'));
    }

    public function edit(Shift $shift)
    {
        // return inertia('Master/Shift/Add', compact('shift'));
        $for = 1;
        return view('pages.masterdata.datapresensi.shift.add', compact('shift','for'));
    }

    public function delete(Shift $shift)
    {
        $cr = $shift->delete();
        if ($cr) {
            return redirect(route('master.shift.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('master.shift.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store()
    {
        $rules = [
            'kode_shift' => 'required',
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
            $rules['kode_shift'] = 'required|unique:shift';
        }

        $data = request()->validate($rules);

        $cr = Shift::updateOrCreate(['id' => request('id')], $data);

        if ($cr) {
            return redirect(route('master.shift.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil!"
            ]);
        } else {
            return redirect(route('master.shift.index'))->with([
                'type' => 'error',
                'messages' => "Gagal!"
            ]);
        }
    }
    public function datatable(DataTables $dataTables)
    {
        $model = Shift::query();
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
                if(getPermission('masterDataShift','U')){
                    $html .= "<a class='me-2 edit' tooltip='Edit' href='" . route('master.shift.edit', $row->id) . "'>" . icons('pencil') . "</a>";
                }
                if(getPermission('masterDataShift','D')){
                    $html .= "<a class='delete text-danger' tooltip='Hapus' href='" . route('master.shift.delete', $row->id) . "'>" . icons('trash') . "</a>";
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
