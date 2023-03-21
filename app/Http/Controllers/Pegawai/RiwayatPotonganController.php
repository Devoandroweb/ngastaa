<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\RiwayatPotonganResource;
use App\Models\Pegawai\RiwayatPotongan;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class RiwayatPotonganController extends Controller
{
    public function index(User $pegawai)
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $nOwner = !role('owner');

        $Rpotongan = RiwayatPotongan::where('nip', $pegawai->nip)
            ->orderByDesc('tanggal_sk')
            ->when($nOwner, function ($qr) {
                $qr->where('is_private', 0);
            })
            ->paginate($limit);

        $Rpotongan->appends(request()->all());
        $Rpotongan = RiwayatPotonganResource::collection($Rpotongan);
        return inertia('Pegawai/Potongan/index', compact('pegawai', 'Rpotongan'));
    }

    public function add(User $pegawai)
    {
        $Rpotongan = null;
        // return inertia('Pegawai/Potongan/Add', compact('pegawai', 'Rpotongan'));
        $for = 0;
        $data['data'] = $Rpotongan;
        $data['view'] = view('pages.pegawai.pegawai.datariwayat.potongan.add',compact('pegawai', 'Rpotongan', 'for'))->render();
        return response()->json($data);
    }

    public function edit(User $pegawai, RiwayatPotongan $Rpotongan)
    {
        // return inertia('Pegawai/Potongan/Add', compact('pegawai', 'Rpotongan'));
  
        $for = 1;

        $data['data'] = $Rpotongan;
        $data['view'] = view('pages.pegawai.pegawai.datariwayat.potongan.add',compact('pegawai', 'Rpotongan', 'for'))->render();
        return response()->json($data);
    }

    public function delete(User $pegawai, RiwayatPotongan $Rpotongan)
    {
        tambah_log($pegawai->nip, "App\Pegawai\RiwayatPotongan", $Rpotongan->id, 'dihapus');
        if ($Rpotongan->file) {
            Storage::delete($Rpotongan->file);
        }
        $cr = $Rpotongan->delete();
        if ($cr) {
            return response()->json(["status"=>true,"msg"=>"Berhasil, dihapus!"]);
        } else {
            return response()->json(["status"=>false,"msg"=>"Gagal, dihapus!"]);
        }
    }

    public function akhir(User $pegawai, RiwayatPotongan $Rpotongan)
    {
        if ($Rpotongan->is_aktif == 1) {
            tambah_log($pegawai->nip, "App\Pegawai\RiwayatPotongan", $Rpotongan->id, 'dinonaktifkan');
            $cr = $Rpotongan->update(['is_aktif' => 0]);
        } else {
            tambah_log($pegawai->nip, "App\Pegawai\RiwayatPotongan", $Rpotongan->id, 'diaktifkan');
            $cr = $Rpotongan->update(['is_aktif' => 1]);
        }
        if ($cr) {
            return redirect(route('pegawai.potongan.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, diperbaharui!"
            ]);
        } else {
            return redirect(route('pegawai.potongan.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, diperbaharui!"
            ]);
        }
    }

    public function store(User $pegawai)
    {
        $rules = [
            'nomor_sk' => 'nullable',
            'tanggal_sk' => 'nullable',
            'kode_kurang' => 'required',
            'is_aktif' => 'required',
            'is_private' => 'nullable',
        ];

        if (request()->file('file')) {
            $rules['file'] = 'mimes:pdf|max:2048';
        }

        $data = request()->validate($rules);
        $data['tanggal_sk'] = date("Y-m-d",strtotime(str_replace("/","-", $data["tanggal_sk"])));

        $id = request('id');
        if ($id) {
            if (request()->file('file')) {
                $file = RiwayatPotongan::where('id', $id)->where('nip', $pegawai->nip)->value('file');
                if ($file) {
                    Storage::delete($file);
                }
            }
            tambah_log($pegawai->nip, "App\Pegawai\RiwayatPotongan", $id, 'diubah');
        }
        if (request()->file('file')) {
            $data['file'] = request()->file('file')->storeAs($pegawai->nip, $pegawai->nip . "-potongan-" . generateRandomString(5) . ".pdf");
        }

        $cr = RiwayatPotongan::updateOrCreate(
            [
                'id' => $id,
                'nip' => $pegawai->nip,
            ],
            $data
        );
        if (!$id) {
            tambah_log($pegawai->nip, "App\Pegawai\RiwayatPotongan", $cr->id, 'ditambahkan');
        }

        if(request()->query("for") == 0){
            if ($cr) {
                return response()->json(["status"=>true,"msg"=>"Berhasil, ditambahkan!"]);
            } else {
                return response()->json(["status"=>false,"msg"=>"Gagal, ditambahkan!"]);
            }
        }else{
            if ($cr) {
                return response()->json(["status"=>true,"msg"=>"Berhasil, diperbarui!"]);
            } else {
                return response()->json(["status"=>false,"msg"=>"Gagal, diperbarui!"]);
            }
        }
    }
    public function datatable($pegawai,DataTables $dataTables)
    {
        
        $nOwner = !role('owner');

        $Rpotongan = RiwayatPotongan::where('nip', $pegawai)
            ->orderByDesc('tanggal_sk')
            ->when($nOwner, function ($qr) {
                $qr->where('is_private', 0);
            })->get();
        // $Rpotongan = RiwayatPotonganResource::collection($Rpotongan);
        return $dataTables->of($Rpotongan)
        ->addColumn('nama', function ($row) {
            return  $row['potongan']['nama'] ;
        })
        ->addColumn('nomor_sk', function ($row) {
            return  $row['nomor_sk'];
        })
        ->addColumn('tanggal_sk', function ($row) {
            return tanggal_indo($row['tanggal_sk']) ;
        })
        ->addColumn('is_private', function ($row) {
            return ($row['is_private'] == 0) ? "<span class='badge badge-danger'>Tidak</span>":"<span class='badge badge-success'>Ya</span>";
        })
        ->addColumn('status', function ($row) {
            return ($row['status'] == 0) ? "<span class='badge badge-danger'>Tidak Aktif</span>" : "<span class='badge badge-success'>Aktif</span>";
        })
        ->addColumn('file', function ($row) {

            return '<a class="badge badge-primary badge-outline" href="' . $row['file'] . '">Lihat Berkas</a>';
        })
        ->addColumn('opsi', function ($row) {

            $html = "<a class='me-2 edit' tooltip='Edit' href='" . route('pegawai.potongan.edit', ['pegawai' => $row['nip'], 'Rpotongan' => $row['id']]) . "'>" . icons('pencil') . "</a>";
            $html .= "<a class='text-danger delete' tooltip='Hapus' href='" . route('pegawai.potongan.delete', ['pegawai' => $row['nip'], 'Rpotongan' => $row['id']]) . "'>" . icons('trash') . "</a>";
            return $html;
        })
        ->rawColumns(['opsi', 'is_private','file','status'])
        ->addIndexColumn()->toJson();
    }
}
