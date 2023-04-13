<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Resources\Master\VisitResource;
use App\Models\Master\Visit;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Yajra\DataTables\DataTables;

class VisitController extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $visit = Visit::when($search, function ($qr, $search) {
            $qr->where('nama', 'LIKE', "%$search%");
        })
            ->paginate($limit);

        $visit->appends(request()->all());

        $visit = VisitResource::collection($visit);

        // return inertia('Master/Visit/index', compact('visit'));
        return view('pages/masterdata/datapresensi/lokasivisit/index');
    }

    public function add()
    {
        $visit = new Visit();
    
        return view('pages\masterdata\datapresensi\lokasivisit\add', compact('visit'));
    }

    public function edit(Visit $visit)
    {
        // dd($visit);
        return view('pages\masterdata\datapresensi\lokasivisit\add', compact('visit'));
    }

    public function delete(Visit $visit)
    {
        $cr = $visit->delete();
        if ($cr) {
            return redirect(route('master.visit.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('master.visit.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store()
    {
        $rules = [
            'kordinat' => 'required',
            'jarak' => 'required',
            'nama' => 'required',
            'polygon' => 'nullable',
        ];

        $data = request()->validate($rules);
        if (!request('id')) {
            $kodeVisit = (string) Str::uuid();
            $data['kode_visit'] = $kodeVisit;
            $qrName = (string) Str::uuid().".svg";
            QrCode::generate($kodeVisit, public_path("visit_qr\\".$qrName));
            $data['qr'] = $qrName;
        }
        $cr = Visit::updateOrCreate(['id' => request('id')], $data);

        if ($cr) {
            return redirect(route('master.visit.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil!"
            ]);
        } else {
            return redirect(route('master.visit.index'))->with([
                'type' => 'error',
                'messages' => "Gagal!"
            ]);
        }
    }
    public function datatable(DataTables $dataTables)
    {
        $model = Visit::with('data_visit');
        return $dataTables->eloquent($model)

            ->addColumn('qr', function ($row) {
                return '<img src="'.url('visit_qr/'.$row->qr).'" alt="">';
            })
            ->addColumn('opsi', function ($row) {
                $html = "<a class='me-2 edit' tooltip='Edit' href='" . route('master.visit.edit', $row->id) . "'>" . icons('pencil') . "</a>";
                $html .= "<a class='delete text-danger' tooltip='Hapus' href='" . route('master.visit.delete', $row->id) . "'>" . icons('trash') . "</a>";
                $html .= "<a class='text-info' tooltip='Hapus' href='" . url('visit_qr/'.$row->qr) . "'>" . icons('download') . " Unduh QR</a>";
                return $html;
            })
            ->rawColumns(['opsi','qr'])
            ->addIndexColumn()
            ->toJson();
    }
}
