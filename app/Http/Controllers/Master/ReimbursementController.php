<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Resources\Master\ReimbursementResource;
use App\Http\Resources\Select\SelectResource;
use App\Models\Master\Reimbursement;
use Yajra\DataTables\DataTables;

class ReimbursementController extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $reimbursement = Reimbursement::when($search, function ($qr, $search) {
            $qr->where('nama', 'LIKE', "%$search%");
        })
            ->paginate($limit);

        $reimbursement->appends(request()->all());

        $reimbursement = ReimbursementResource::collection($reimbursement);

        // return inertia('Master/Reimbursement/index', compact('reimbursement'));
        return view('pages/masterdata/datalainya/reimbursement/index');
    }

    public function json()
    {
        $reimbursement = Reimbursement::orderBy('nama')->get();
        SelectResource::withoutWrapping();
        $reimbursement = SelectResource::collection($reimbursement);

        return response()->json($reimbursement);
    }

    public function add()
    {
        $reimbursement = new Reimbursement();
        // return inertia('Master/Reimbursement/Add', compact('reimbursement'));
        return view('pages/masterdata/datalainya/reimbursement/add');
    }

    public function edit(Reimbursement $reimbursement)
    {
        // return inertia('Master/Reimbursement/Add', compact('reimbursement'));
        return view('pages/masterdata/datalainya/reimbursement/edit', compact('reimbursement'));
    }

    public function delete(Reimbursement $reimbursement)
    {
        $cr = $reimbursement->delete();
        if ($cr) {
            return redirect(route('master.reimbursement.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('master.reimbursement.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store()
    {
        $rules = [
            'kode_reimbursement' => 'required',
            'nama' => 'required',
        ];

        if (!request('id')) {
            $rules['kode_reimbursement'] = 'required|unique:reimbursement';
        }

        $data = request()->validate($rules);

        $cr = Reimbursement::updateOrCreate(['id' => request('id')], $data);

        if ($cr) {
            return redirect(route('master.reimbursement.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil!"
            ]);
        } else {
            return redirect(route('master.reimbursement.index'))->with([
                'type' => 'error',
                'messages' => "Gagal!"
            ]);
        }
    }
    public function datatable(DataTables $dataTables)
    {
        $model = Reimbursement::query();
        return $dataTables->eloquent($model)
            ->addColumn('opsi', function ($row) {

                $html = "<a class='me-2 edit' tooltip='Edit' href='" . route('master.reimbursement.edit', $row->id) . "'>" . icons('pencil') . "</a>";
                $html .= "<a class='delete text-danger' tooltip='Hapus' href='" . route('master.reimbursement.delete', $row->id) . "'>" . icons('trash') . "</a>";
                return $html;
            })
            ->rawColumns(['opsi'])
            ->addIndexColumn()
            ->toJson();
    }
}
