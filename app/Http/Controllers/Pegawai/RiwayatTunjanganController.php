<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\RiwayatTunjanganResource;
use App\Models\Pegawai\RiwayatTunjangan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class RiwayatTunjanganController extends Controller
{
    public function index(User $pegawai)
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $nOwner = !role('owner');

        $Rtunjangan = RiwayatTunjangan::where('nip', $pegawai->nip)
            ->orderByDesc('tanggal_sk')
            ->when($nOwner, function ($qr) {
                $qr->where('is_private', 0);
            })
            ->paginate($limit);

        $Rtunjangan->appends(request()->all());
        $Rtunjangan = RiwayatTunjanganResource::collection($Rtunjangan);
        return inertia('Pegawai/Tunjangan/index', compact('pegawai', 'Rtunjangan'));
    }

    public function add(User $pegawai)
    {
        $Rtunjangan = null;
        // return view('pages.pegawai.pegawai.datariwayat.tunjangan.add',compact('pegawai', 'Rtunjangan'));
        $for = 0;
        $data['data'] = $Rtunjangan;
        $data['view'] = view('pages.pegawai.pegawai.datariwayat.tunjangan.add',compact('pegawai', 'Rtunjangan', 'for'))->render();
        return response()->json($data);
    }

    public function edit(User $pegawai, RiwayatTunjangan $Rtunjangan)
    {
        // return inertia('Pegawai/Tunjangan/Add', compact('pegawai', 'Rtunjangan'));
        // $Rtunjangan = null;
        $for = 1;
        $data['data'] = $Rtunjangan;
        $data['view'] = view('pages.pegawai.pegawai.datariwayat.tunjangan.add',compact('pegawai', 'Rtunjangan', 'for'))->render();
        return response()->json($data);
        // return view('pages.pegawai.pegawai.datariwayat.tunjangan.edit',compact('pegawai', 'Rtunjangan'));
    }

    public function delete(User $pegawai, RiwayatTunjangan $Rtunjangan)
    {
        tambah_log($pegawai->nip, "App\Pegawai\RiwayatTunjangan", $Rtunjangan->id, 'dihapus');
        if ($Rtunjangan->file) {
            Storage::delete($Rtunjangan->file);
        }
        $cr = $Rtunjangan->delete();
        if ($cr) {
            return response()->json(["status"=>true,"msg"=>"Berhasil, dihapus!"]);
        } else {
            return response()->json(["status"=>false,"msg"=>"Gagal, dihapus!"]);
        }
    }

    public function akhir(User $pegawai, RiwayatTunjangan $Rtunjangan)
    {
        if ($Rtunjangan->is_aktif == 1) {
            tambah_log($pegawai->nip, "App\Pegawai\RiwayatTunjangan", $Rtunjangan->id, 'dinonaktifkan');
            $cr = $Rtunjangan->update(['is_aktif' => 0]);
        } else {
            tambah_log($pegawai->nip, "App\Pegawai\RiwayatTunjangan", $Rtunjangan->id, 'diaktifkan');
            $cr = $Rtunjangan->update(['is_aktif' => 1]);
        }
        if ($cr) {
            return response()->json(["status"=>true,"msg"=>"Berhasil, diperbarui!"]);
        } else {
            return response()->json(["status"=>false,"msg"=>"Gagal, diperbarui!"]);
        }
    }

    public function store(User $pegawai)
    {
        $rules = [
            'nomor_sk' => 'required',
            'tanggal_sk' => 'required',
            'kode_tunjangan' => 'required',
            'nilai' => 'required',
            'is_aktif' => 'required',
            'is_private' => 'nullable',
        ];

        if (request()->file('file')) {
            $rules['file'] = 'mimes:pdf|max:2048';
        }

        
        $data = request()->validate($rules);
        
        $data['nilai'] = number_to_sql($data['nilai']);
        $data['tanggal_sk'] = date('Y-m-d', strtotime(str_replace("/","-", $data["tanggal_sk"])));
        $id = request('id');
        if ($id) {
            if (request()->file('file')) {
                $file = RiwayatTunjangan::where('id', $id)->where('nip', $pegawai->nip)->value('file');
                if ($file) {
                    Storage::delete($file);
                }
            }
            tambah_log($pegawai->nip, "App\Pegawai\RiwayatTunjangan", $id, 'diubah');
        }
        if (request()->file('file')) {
            // $data['file'] = request()->file('file')->storeAs($pegawai->nip, $pegawai->nip . "-tunjangan-" . date("Ymdhis") . ".pdf");
            $dir = 'data_pegawai/'.$pegawai->nip.'/tunjangan';
            $data['file'] = $dir.'/'.uploadFile($dir,request()->file('file'));
        }

        $cr = RiwayatTunjangan::updateOrCreate(
            [
                'id' => $id,
                'nip' => $pegawai->nip,
            ],
            $data
        );
        if (!$id) {
            tambah_log($pegawai->nip, "App\Pegawai\RiwayatTunjangan", $cr->id, 'ditambahkan');
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
    public function datatable($pegawai, DataTables $dataTables)
    {

        $nOwner = !role('owner');
        $Rtunjangan = RiwayatTunjangan::where('nip', $pegawai)
            ->orderByDesc('tanggal_sk')
            ->when($nOwner, function ($qr) {
                $qr->where('is_private', 0);
            })
            ->get();
        // $Rtunjangan = RiwayatTunjanganResource::collection($Rtunjangan);
        return $dataTables->of($Rtunjangan)
        ->addColumn('nama', function ($row) {
            return  $row['tunjangan']['nama'] ;
        })
        ->addColumn('nomor_sk', function ($row) {
            return  $row['nomor_sk'];
        })
        ->addColumn('tanggal_sk', function ($row) {
            return tanggal_indo($row['tanggal_sk']) ;
        })
        ->addColumn('is_private', function ($row) {
            return isPrivateBagde($row['is_private']) ;
        })
        ->addColumn('status', function ($row) {
            return ($row['status'] == 0) ? "<span class='badge badge-danger'>Tidak Aktif</span>" : "<span class='badge badge-success'>Aktif</span>";
        })
        ->addColumn('file', function ($row) {
            if(is_null($row['file'])){
                    return "-";
            }
            return '<a class="badge badge-primary badge-outline" href="' . $row['file'] . '">Lihat Berkas</a>';
        })
        ->addColumn('opsi', function ($row) {

            $html = "<a class='me-2 edit' tooltip='Edit' href='" . route('pegawai.tunjangan.edit', ['pegawai' => $row['nip'], 'Rtunjangan' => $row['id']]) . "'>" . icons('pencil') . "</a>";
            $html .= "<a class='text-danger delete' tooltip='Hapus' href='" . route('pegawai.tunjangan.delete', ['pegawai' => $row['nip'], 'Rtunjangan' => $row['id']]) . "'>" . icons('trash') . "</a>";
            return $html;
        })
        ->rawColumns(['opsi', 'is_private', 'file', 'status'])
        ->addIndexColumn()->toJson();
    }
}
