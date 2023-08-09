<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Resources\Master\LokasiResource;
use App\Http\Resources\Pegawai\PegawaiResource;
use App\Http\Resources\Select\SelectResource;
use App\Http\Resources\SelectTingkatResource;
use App\Models\Master\Lokasi;
use App\Models\Master\LokasiDetail;
use App\Models\Master\Shift;
use App\Models\Master\Skpd;
use App\Models\Master\Tingkat;
use App\Models\User;
use Yajra\DataTables\DataTables;

class LokasiController extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $lokasi = Lokasi::when($search, function ($qr, $search) {
            $qr->where('nama', 'LIKE', "%$search%");
        })
            ->paginate($limit);

        $lokasi->appends(request()->all());

        $lokasi = LokasiResource::collection($lokasi);

        // return inertia('Master/Lokasi/index', compact('lokasi'));
        return view('pages/masterdata/datapresensi/lokasikerja/index');
    }

    public function json()
    {
        $lokasi = Lokasi::orderBy('nama')->get();
        SelectResource::withoutWrapping();
        $lokasi = SelectResource::collection($lokasi);

        return response()->json($lokasi);
    }

    public function add()
    {
        $lokasi = new Lokasi();
        $parent = Tingkat::with(str_repeat('children.', 99))->whereNull('parent_id')->get();
        SelectTingkatResource::withoutWrapping();
        $parent = SelectTingkatResource::collection($parent);
        // dd($parent);
        $shift = Shift::orderBy('nama')->get();
        $skpd = Skpd::get();
        $keterangan = [
            ["value" => '1', "keterangan" => '1', "label" => 'Pilih Pegawai'],
            ["value" => '2', "keterangan" => '2', "label" => 'Berdasarkan Jabatan'],
            ["value" => '3', "keterangan" => '3', "label" => 'Berdasarkan Divisi'],
        ];
        // dd($shift);
        // return inertia('Master/Lokasi/Add', compact('lokasi', 'parent'));
        // return inertia('Master/Lokasi/Add', compact('lokasi', 'parent'));
        return view('pages/masterdata/datapresensi/lokasikerja/add', compact('shift', 'keterangan','skpd'));
    }

    public function edit(Lokasi $lokasi)
    {
        if ($lokasi->keterangan == '2') {
            $lokasiDetail = LokasiDetail::where('kode_lokasi', $lokasi->kode_lokasi)->get()->pluck('keterangan_id')->toArray();
            $lokasiDetail = $lokasiDetail ? $lokasiDetail[0] : [];
        } elseif ($lokasi->keterangan == '3') {
            $lokasiDetail = LokasiDetail::where('kode_lokasi', $lokasi->kode_lokasi)->get()->pluck('keterangan_id')->toArray();
            $lokasiDetail = $lokasiDetail ? Skpd::where('kode_skpd', $lokasiDetail[0])->first() : [];
            // LokasiResource::withoutWrapping();
            // $lokasiDetail = SelectResource::make($lokasiDetail);
        } else {
            $lokasiDetail = LokasiDetail::where('kode_lokasi', $lokasi->kode_lokasi)->get()->pluck('keterangan_id')->toArray();
            $lokasiDetail = User::whereIn('nip', $lokasiDetail)->orderBy('name')->get();
            // LokasiResource::withoutWrapping();
            // $lokasiDetail = SelectResource::collection($lokasiDetail);
        }
        // dd($lokasiDetail);
        $parent = Tingkat::with(str_repeat('children.', 99))->whereNull('parent_id')->get();
        SelectTingkatResource::withoutWrapping();
        $parent = SelectTingkatResource::collection($parent);
        $shift = Shift::orderBy('nama')->get();
        $skpd = Skpd::get();
        $keterangan = [
            ["value" => '1', "keterangan" => '1', "label" => 'Pilih Pegawai'],
            ["value" => '2', "keterangan" => '2', "label" => 'Berdasarkan Jabatan'],
            ["value" => '3', "keterangan" => '3', "label" => 'Berdasarkan Divisi'],
        ];
        // return inertia('Master/Lokasi/Add', );
        return view('pages/masterdata/datapresensi/lokasikerja/edit', compact('lokasi', 'parent', 'lokasiDetail', 'shift', 'keterangan','skpd'));
    }

    public function delete(Lokasi $lokasi)
    {
        $cr = $lokasi->delete();
        if ($cr) {
            return redirect(route('master.lokasi.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('master.lokasi.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store()
    {
        // $detail = json_decode(request('keterangan')[0]);
        // dd(request()->all());
        $rules = [
            'values.kode_lokasi' => 'required',
            'values.nama' => 'required',
            'values.kode_shift' => 'required',
            'values.keterangan' => 'required',
            'kordinat.kordinat' => 'nullable',
            'kordinat.latitude' => 'nullable',
            'kordinat.longitude' => 'nullable',
            'kordinat.jarak' => 'nullable',
            'polygon' => 'nullable',
        ];

        if (!request('values.id')) {
            $cek = Lokasi::where('kode_lokasi', request('values.kode_lokasi'))->first();
            if ($cek) {
                return redirect(route('master.lokasi.index'))->with([
                    'type' => 'error',
                    'messages' => "Kode Lokasi Wajib Tidak Boleh Sama!"
                ]);
            }
        }

        $data = request()->validate($rules);
        $data = $data['values'];
        $data = array_merge($data, request('kordinat'));
        $data['polygon'] = request('polygon');
        $detail = request('keterangan');
        // dd($data);
        if ($detail == "") {
            return redirect(route('master.lokasi.index'))->with([
                'type' => 'error',
                'messages' => "Data Wajib diisi!"
            ]);
        }

        $cr = Lokasi::updateOrCreate(['id' => request('values.id')], $data);

        if (request('values.id')) {
            LokasiDetail::where('kode_lokasi', $data['kode_lokasi'])->delete();
        }
        // dd($data)['keterangan'];
        // dd($detail);
        if ($data['keterangan'] == 1) {
            foreach ($detail as $d) {
                // dd(json_decode($d)->nip);
                LokasiDetail::create([
                    'kode_lokasi' => $data['kode_lokasi'],
                    'keterangan_tipe' => $data['keterangan'],
                    'keterangan_id' => json_decode($d)->nip
                ]);
            }
        } elseif ($data['keterangan'] == 2) {
            LokasiDetail::create([
                'kode_lokasi' => $data['kode_lokasi'],
                'keterangan_tipe' => $data['keterangan'],
                'keterangan_id' => $detail['kode_tingkat']
            ]);
        } elseif ($data['keterangan'] == 3) {
            // dd($detail);
            LokasiDetail::create([
                'kode_lokasi' => $data['kode_lokasi'],
                'keterangan_tipe' => $data['keterangan'],
                // 'keterangan_id' => $detail['kode_skpd']
                'keterangan_id' => $detail
            ]);
        }

        if ($cr) {
            return redirect(route('master.lokasi.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil!"
            ]);
        } else {
            return redirect(route('master.lokasi.index'))->with([
                'type' => 'error',
                'messages' => "Gagal!"
            ]);
        }
    }
    public function datatable(DataTables $dataTables)
    {
        $model = Lokasi::query();
        return $dataTables->eloquent($model)
            
            ->addColumn('opsi', function ($row) {
                $html = "-";
                if(role('admin') || role('owner')){
                    $html = "<a class='me-2 edit' tooltip='Edit' href='" . route('master.lokasi.edit', $row->id) . "'>" . icons('pencil') . "</a>";
                    $html .= "<a class='delete text-danger delete' tooltip='Hapus' href='" . route('master.lokasi.delete', $row->id) . "'>" . icons('trash') . "</a>";
                }
                return $html;
            })
            ->rawColumns(['opsi'])
            ->addIndexColumn()
            ->toJson();
    }
}
