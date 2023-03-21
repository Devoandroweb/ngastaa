<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Resources\Master\PayrollLemburResource;
use App\Http\Resources\Select\SelectResource;
use App\Models\Master\Payroll\Lembur;
use App\Models\Master\Payroll\Tunjangan;
use Yajra\DataTables\DataTables;

class PayrollLemburController extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $lembur = Lembur::when($search, function ($qr, $search) {
            $qr->where('jam', 'LIKE', "%$search%");
        })
            ->paginate($limit);

        $lembur->appends(request()->all());

        $lembur = PayrollLemburResource::collection($lembur);

        // return inertia('Master/Payroll/Lembur/index', compact('lembur'));
        return view('pages/masterdata/datapayroll/masterlembur/index');
    }

    public function edit(Lembur $lembur)
    {
        $tunjangan = array_map('trim', explode(',', $lembur->kode_tunjangan));
        SelectResource::withoutWrapping();
        $tunjangan = SelectResource::collection(Tunjangan::whereIn("kode_tunjangan", $tunjangan)->get());
        // return inertia('Master/Payroll/Lembur/Add', compact('lembur'));
        $tunjanganAll = Tunjangan::all();
        // dd($tunjanganAll);

        return view('pages/masterdata/datapayroll/masterlembur/edit', compact('tunjangan', 'lembur', 'tunjanganAll'));
    }


    public function update()
    {
        // dd(request()->all());
        $rules = [
            'jam' => 'required',
            'kode_tunjangan' => 'required',
            'pengali' => 'required',
        ];

        $data = request()->validate($rules);
        $tunjanganString = "";
        foreach (request('kode_tunjangan') as $k => $tunjangan) {
            if ($k == 0) {
                $tunjanganString .= json_decode($tunjangan)->kode_tunjangan;
            } else {
                $tunjanganString .= ", " . json_decode($tunjangan)->kode_tunjangan;
            }
        }
        $data['kode_tunjangan'] = $tunjanganString;

        $cr = Lembur::where(['jam' => request('jam')])->update($data);

        if ($cr) {
            return redirect(route('master.payroll.lembur.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil!"
            ]);
        } else {
            return redirect(route('master.payroll.lembur.index'))->with([
                'type' => 'error',
                'messages' => "Gagal!"
            ]);
        }
    }
    public function datatable(DataTables $dataTables)
    {
        $model = Lembur::query();
        return $dataTables->eloquent($model)
            ->addColumn('tunjangan', function ($row) {
                return master_tunjangan($row->kode_tunjangan);
            })
            ->addColumn('opsi', function ($row) {

                $html = "<a class='me-2 edit' tooltip='Edit' href='" . route('master.payroll.lembur.edit', $row->id) . "'>" . icons('pencil') . "</a>";
                return $html;
            })
            ->rawColumns(['opsi'])
            ->addIndexColumn()
            ->toJson();
    }
}
