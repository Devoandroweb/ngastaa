<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Resources\Master\SkpdResource;
use App\Http\Resources\Select\SelectResource;
use App\Models\Kabupaten;
use App\Models\Master\Skpd;
use App\Repositories\Divisi\DivisiRepository;
use Yajra\DataTables\DataTables;

class SkpdController extends Controller
{
    protected $kabupaten;
    protected $divisiRepository;
    function __construct(DivisiRepository $divisiRepository){
        $this->kabupaten = Kabupaten::orderBy('name')->get();
        $this->divisiRepository = $divisiRepository;
    }
    public function index()
    {

        $titlePage = "Data Divisi Kerja"; //wajib
        return view('pages/masterdata/datajabatan/divisikerja/index', compact('titlePage'));
    }

    public function json()
    {
        $skpd = Skpd::when(request()->query("q") != "",function($query){
            // dd(request()->query("q"));

            $query->where("nama","like","%".request()->query("q")."%");
        })->orderBy('nama')->get();
        // dd($skpd);
        SelectResource::withoutWrapping();
        $skpd = SelectResource::collection($skpd);
        // dd($skpd);
        return response()->json($skpd);
    }

    public function bawahan()
    {
        $skpd = request('skpd');

        $skpd = Skpd::orderBy('nama')->where('kode_atasan', $skpd)->get();
        SelectResource::withoutWrapping();
        $skpd = SelectResource::collection($skpd);

        return response()->json($skpd);
    }

    public function add()
    {
        $skpd = new Skpd();
        // return inertia('Master/Skpd/Add', compact('skpd'));
        return view('pages/masterdata/datajabatan/divisikerja/add')->with('kabupaten',$this->kabupaten);
    }

    public function edit(Skpd $skpd)
    {
        // return inertia('Master/Skpd/Add', compact('skpd'));
        $skpd = $skpd->load('kota');
        // dd($skpd->kota);
        return view('pages/masterdata/datajabatan/divisikerja/edit', compact('skpd'))->with('kabupaten',$this->kabupaten);
    }

    public function reset(Skpd $skpd)
    {
        $cr = $skpd->update([
            'kordinat' => null,
            'latitude' => null,
            'longitude' => null,
            'jarak' => 0,
            'polygon' => null,
        ]);
        if ($cr) {
            return redirect(route('master.skpd.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, direset!"
            ]);
        } else {
            return redirect(route('master.skpd.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, direset!"
            ]);
        }
    }

    public function delete(Skpd $skpd)
    {
        $cr = $skpd->delete();
        if ($cr) {
            return redirect(route('master.skpd.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('master.skpd.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store()
    {
        $rules = [
            'kode_skpd' => 'required',
            'nama' => 'required',
            'singkatan' => 'required',
            'kordinat' => 'nullable',
            'latitude' => 'nullable',
            'longitude' => 'nullable',
            'jarak' => 'nullable',
            'polygon' => 'nullable',
            'code_city' => 'required',
        ];
        if (!request('id')) {
            $rules['kode_skpd'] = 'required|unique:skpd';
        }

        $data = request()->validate($rules);
        // dd($data);

        $cr = $this->divisiRepository->updateOrCreate(request('id'),$data);

        if ($cr) {
            return redirect(route('master.skpd.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil!"
            ]);
        } else {
            return redirect(route('master.skpd.index'))->with([
                'type' => 'error',
                'messages' => "Gagal!"
            ]);
        }
    }
    public function datatable(DataTables $dataTables)
    {
        $model = $this->divisiRepository->allDivisionWithRole();
        // dd($model->get());
        return $dataTables->eloquent($model)
            ->addColumn('opsi', function ($row) {
                $html = "-";
                // $html = "<a class='me-2 reset' href='" . route('master.skpd.reset', $row->id) . "'>" . icons('refresh') . "</a>";

                if(getPermission('masterDataDivisiKerja','U')  || role('owner') || role('admin')){
                    $html = "<a class='me-2 edit' tooltip='Edit' href='" . route('master.skpd.edit', $row->id) . "'>" . icons('pencil') . "</a>";
                }
                if(getPermission('masterDataDivisiKerja','RST') || role('owner') || role('admin')){
                    $html .= "<a class='me-2 reset' tooltip='Reset' href='" . route('master.skpd.reset', $row->id) . "'>" . icons('refresh') . "</a>";
                }
                if(getPermission('masterDataDivisiKerja','D') || role('owner') || role('admin')){
                    $html .= "<a class='delete text-danger delete' tooltip='Hapus' href='" . route('master.skpd.delete', $row->id) . "'>" . icons('trash') . "</a>";
                }
                return $html;
            })
            ->rawColumns(['opsi'])
            ->addIndexColumn()
            ->toJson();
    }
}
