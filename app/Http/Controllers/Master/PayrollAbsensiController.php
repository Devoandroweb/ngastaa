<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Resources\Master\PayrollAbsensiResource;
use App\Http\Resources\Select\SelectResource;
use App\Models\Master\Payroll\Absensi;
use App\Models\Master\Payroll\Tunjangan;
use Yajra\DataTables\DataTables;

class PayrollAbsensiController extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $absensi = Absensi::when($search, function ($qr, $search) {
            $qr->where('jam', 'LIKE', "%$search%");
        })
            ->paginate($limit);

        $absensi->appends(request()->all());

        $absensi = PayrollAbsensiResource::collection($absensi);

        // return inertia('Master/Payroll/Absensi/index', compact('absensi'));
        return view('pages/masterdata/datapayroll/potongantelat/index');
    }

    public function edit(Absensi $absensi)
    {
        $tunjangan = array_map('trim', explode(',', $absensi->kode_tunjangan));
        SelectResource::withoutWrapping();
        $tunjangan = SelectResource::collection(Tunjangan::whereIn("kode_tunjangan", $tunjangan)->get());
        $tunjanganAll = Tunjangan::all();
        // dd($tunjangan);
        // return inertia('Master/Payroll/Absensi/Add', compact('absensi'));
        return view('pages/masterdata/datapayroll/potongantelat/edit', compact('absensi', 'tunjangan', 'tunjanganAll'));
    }

    public function update()
    {
        $rules = [
            'menit' => 'required',
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

        $cr = Absensi::where(['id' => request('id')])->update($data);

        if ($cr) {
            return redirect(route('master.payroll.absensi.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil!"
            ]);
        } else {
            return redirect(route('master.payroll.absensi.index'))->with([
                'type' => 'error',
                'messages' => "Gagal!"
            ]);
        }
    }
    public function datatable(DataTables $dataTables)
    {
        $model = Absensi::query();
        return $dataTables->eloquent($model)
            ->addColumn('menit', function ($row) {
                return $row->keterangan == 1 ? "Telat $row->menit Menit" : "Cepat Pulang $row->menit Menit";
            })
            ->addColumn('tunjangan', function ($row) {
                return master_tunjangan($row->kode_tunjangan);
            })
            ->addColumn('opsi', function ($row) {

                $html = "<a class='me-2 edit' tooltip='Edit' href='" . route('master.payroll.absensi.edit', $row->id) . "'>" . icons('pencil') . "</a>";
                return $html;
            })
            ->rawColumns(['opsi'])
            ->addIndexColumn()
            ->toJson();
    }
}
