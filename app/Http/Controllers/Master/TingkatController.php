<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Resources\Master\TingkatResource;
use App\Http\Resources\Select\SelectResource;
use App\Http\Resources\SelectTingkatResource;
use App\Models\Master\Eselon;
use App\Models\Master\Skpd;
use App\Models\Master\Tingkat;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TingkatController extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $tingkat = Tingkat::when($search, function ($qr, $search) {
            $qr->where('nama', 'LIKE', "%$search%");
        })
            ->paginate($limit);

        $tingkat->appends(request()->all());

        $tingkat = TingkatResource::collection($tingkat);

        // return inertia('Master/Tingkat/index', compact('tingkat'));

        return view('pages/masterdata/datajabatan/tingkatjabatan/index');
    }

    public function json($skpd = null)
    {
        // $tingkat = Tingkat::with(str_repeat('children.', 99))->whereNull('parent_id')->when($skpd, function ($qr, $skpd) {
        //     $qr->where('kode_skpd', $skpd);
        // })->orderBy('nama')->get();
        $tingkat = Tingkat::when($skpd, function ($qr, $skpd) {
            $qr->where('kode_skpd', $skpd);
        })->orderBy('nama')->get();
        SelectTingkatResource::withoutWrapping();
        $tingkat = SelectTingkatResource::collection($tingkat);

        return response()->json($tingkat);
    }

    public function add()
    {
        $tingkat = new Tingkat();
        $parent = Tingkat::with(str_repeat('children.', 99))->whereNull('parent_id')->get();
        SelectTingkatResource::withoutWrapping();
        $parent = SelectTingkatResource::collection($parent);
        $skpd = Skpd::all();
        $eselon = Eselon::orderBy('nama')->get();
        $jenisJabatan = [
            ["value" => '1', "jenis_jabatan" => '1', 'label' => 'Struktural'],
            ["value" => '2', "jenis_jabatan" => '2', 'label' => 'Fungsional'],
            ["value" => '4', "jenis_jabatan" => '4', 'label' => 'Pelaksana']
        ];
        // return inertia('Master/Tingkat/Add', compact('tingkat', 'parent'));
        return view(
            'pages/masterdata/datajabatan/tingkatjabatan/add',
            compact('tingkat', 'parent', 'skpd', 'jenisJabatan', 'eselon')
        );
    }

    public function edit(Tingkat $tingkat)
    {
        $parent = Tingkat::with(str_repeat('children.', 99))->whereNull('parent_id')->get();
        SelectTingkatResource::withoutWrapping();
        $parent = SelectTingkatResource::collection($parent);
        $skpd = Skpd::all();
        $eselon = Eselon::orderBy('nama')->get();
        $jenisJabatan = [
            ["value" => '1', "jenis_jabatan" => '1', 'label' => 'Struktural'],
            ["value" => '2', "jenis_jabatan" => '2', 'label' => 'Fungsional'],
            ["value" => '4', "jenis_jabatan" => '4', 'label' => 'Pelaksana']
        ];
        // return inertia('Master/Tingkat/Add', compact('tingkat', 'parent'));
        return view(
            'pages/masterdata/datajabatan/tingkatjabatan/edit',
            compact('tingkat', 'parent', 'skpd', 'jenisJabatan', 'eselon')
        );
    }

    public function delete(Tingkat $tingkat)
    {
        $cr = $tingkat->delete();
        if ($cr) {
            return redirect(route('master.tingkat.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('master.tingkat.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store()
    {
        // dd(request()->all());
        // $rules = [
        //     'values.nama' => 'required',
        //     'values.kode_tingkat' => 'required',
        //     'values.kode_eselon' => 'required',
        //     'values.jenis_jabatan' => 'required',
        //     'values.kode_skpd' => 'required',
        //     // 'values.parent_id' => 'nullable',
        //     'values.gaji_pokok' => 'required',
        //     'values.tunjangan' => 'required',
        // ];
        $rules = [
            'nama' => 'required',
            'kode_tingkat' => 'required',
            'kode_eselon' => 'required',
            'jenis_jabatan' => 'required',
            'kode_skpd' => 'required',
            // 'parent_id' => 'nullable',
            'gaji_pokok' => 'required',
            'tunjangan' => 'required',
            'polygon' => 'nullable',
        ];

        if (!request('id')) {
            $cek = Tingkat::where('kode_tingkat', request('kode_tingkat'))->first();
            if ($cek) {
                return redirect(route('master.tingkat.index'))->with([
                    'type' => 'error',
                    'messages' => "Kode Tingkat Wajib Tidak Boleh Sama!"
                ]);
            }
        }

        $data = request()->validate($rules);
        // dd(request('kordinat'));
        // dd($data);
        // $data = $data['values'];
        if (request('kordinat')) {
            $kordinat = explode(",", request('kordinat'));
            $lat = $kordinat[0];
            $long = $kordinat[1];
        }else{
            $lat = 0;
            $long = 0;
        }
        // $data = array_merge($data, request('kordinat'));
        $data['jarak'] = request('jarak');
        $data['kordinat'] = request('kordinat');
        $data['latitude'] = $lat;
        $data['longitude'] = $long;
        $data['gaji_pokok'] = number_to_sql($data['gaji_pokok']);
        $data['tunjangan'] = number_to_sql($data['tunjangan']);

        // dd($data);
        if (request('id')) {
            $cr = Tingkat::where(['id' => request('id')])->update($data);
        } else {
            $cr = Tingkat::create($data);
        }


        if ($cr) {
            return redirect(route('master.tingkat.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil!"
            ]);
        } else {
            return redirect(route('master.tingkat.index'))->with([
                'type' => 'error',
                'messages' => "Gagal!"
            ]);
        }
    }
    function checkKodeTingkat(Request $request)
    {
        $cek = null;
        if (isset($request->kode_tingkat_old)) {
            if ($request->kode_tingkat_old == $request->kode_tingkat) {
                return response()->json(['msg' => 'Oke !!'], 200);
            }
        }
        $cek = Tingkat::where('kode_tingkat', $request->kode_tingkat)->first();
        if ($cek) {
            return response()->json(['msg' => 'Kode Tingkat Sudah Ada !!'], 201);
        }
        return response()->json(['msg' => 'Oke !!'], 200);
    }
    public function org()
    {
        $kode_skpd = request('kode_skpd') ?? Skpd::value("kode_skpd");
        $urlStorage = url("/storage");
        $urlPublic = url("/no-image.png");
        $parent = Tingkat::selectRaw("tingkat.kode_tingkat as id, tingkat.parent_id as pid, tingkat.nama as title, IFNULL(users.name, '-') as name, IF(image is null, '$urlPublic', CONCAT('$urlStorage/', image)) as img")
            ->leftJoin('riwayat_jabatan', function ($qr) {
                $qr->on("riwayat_jabatan.kode_tingkat", "tingkat.kode_tingkat")
                    ->leftJoin("users", "users.nip", "riwayat_jabatan.nip")
                    ->where('riwayat_jabatan.is_akhir', 1);
            })
            ->where('tingkat.kode_skpd', $kode_skpd)
            ->get()->makeHidden(['parent', 'parents'])->toArray();
        return inertia("Master/Tingkat/Org", compact("parent", 'kode_skpd'));
    }
    public function datatable(DataTables $dataTables)
    {
        $model = Tingkat::with('eselon');
        return $dataTables->eloquent($model)
            ->addColumn('nama_eselon', function ($row) {
                return $row->eselon?->nama ?? "-";
            })
            ->addColumn('nama_skpd', function ($row) {
                return $row->skpd?->nama ?? "-";
            })
            ->addColumn('opsi', function ($row) {
                $html = "<a class='me-2 edit' tooltip='Edit' href='" . route('master.tingkat.edit', $row->id) . "'>" . icons('pencil') . "</a>";
                $html .= "<a class='delete text-danger' tooltip='Hapus' href='" . route('master.tingkat.delete', $row->id) . "'>" . icons('trash') . "</a>";
                return $html;
            })
            ->rawColumns(['opsi'])
            ->addIndexColumn()
            ->toJson();
    }
}
