<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Resources\Master\CutiResource;
use App\Http\Resources\Select\SelectResource;
use App\Models\Master\Cuti;
use App\Models\Presensi\TotalIzin;
use App\Models\Presensi\TotalPresensi;
use App\Repositories\Pegawai\PegawaiRepository;
use Yajra\DataTables\DataTables;

class CutiController extends Controller
{
    protected $pegawaiRepository;
    function __construct(PegawaiRepository $pegawaiRepository)
    {
        $this->pegawaiRepository = $pegawaiRepository;
    }
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $cuti = Cuti::when($search, function ($qr, $search) {
            $qr->where('nama', 'LIKE', "%$search%");
        })
            ->paginate($limit);

        $cuti->appends(request()->all());

        $cuti = CutiResource::collection($cuti);

        // return inertia('Master/Cuti/index', compact('cuti'));

        return view('pages/masterdata/datapresensi/cuti/index');
    }

    public function json()
    {
        $cuti = Cuti::orderBy('nama')->get();
        SelectResource::withoutWrapping();
        $cuti = SelectResource::collection($cuti);

        return response()->json($cuti);
    }

    public function add()
    {
        $cuti = new Cuti();
        // return inertia('Master/Cuti/Add', compact('cuti'));
        return view('pages/masterdata/datapresensi/cuti/add');
    }

    public function edit(Cuti $cuti)
    {
        // return inertia('Master/Cuti/Add', compact('cuti'));
        return view('pages/masterdata/datapresensi/cuti/edit', compact('cuti'));
    }

    public function delete(Cuti $cuti)
    {
        $cr = $cuti->delete();
        if ($cr) {
            return redirect(route('master.cuti.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('master.cuti.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store()
    {
        $rules = [
            'kode_cuti' => 'required',
            'nama' => 'required',
        ];

        if (!request('id')) {
            //new
            $rules['kode_cuti'] = 'required|unique:cuti';
        }
        
        $data = request()->validate($rules);
        
        $cr = Cuti::updateOrCreate(['id' => request('id')], $data);
        if ($cr) {
            if (!request('id')) {
                $dataInsert = [];
                $dataPegawai = $this->pegawaiRepository->getAllPegawai();
                foreach ($dataPegawai as $pegawai) {
                    array_push($dataInsert,[
                        'nip' => $pegawai->nip,
                        'kode_cuti' => $cr->kode_cuti,
                        'periode_bulan' => date("Y-m")
                    ]);
                }
                // dd($dataInsert);
                //new total presensi
                TotalIzin::insert($dataInsert);      
                
            }
            return redirect(route('master.cuti.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil!"
            ]);
        } else {
            return redirect(route('master.cuti.index'))->with([
                'type' => 'error',
                'messages' => "Gagal!"
            ]);
        }
    }
    public function datatable(DataTables $dataTables)
    {
        $model = Cuti::query();
        return $dataTables->eloquent($model)
            ->addColumn('opsi', function ($row) {

                $html = "<a class='me-2 edit' tooltip='Edit' href='" . route('master.cuti.edit', $row->id) . "'>" . icons('pencil') . "</a>";
                $html .= "<a class='delete text-danger' tooltip='Hapus' href='" . route('master.cuti.delete', $row->id) . "'>" . icons('trash') . "</a>";
                return $html;
            })
            ->rawColumns(['opsi'])
            ->addIndexColumn()
            ->toJson();
    }
}
