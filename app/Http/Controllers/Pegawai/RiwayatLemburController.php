<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\RiwayatLemburResource;
use App\Http\Resources\Pengajuan\LemburPengajuanResource;
use App\Models\Pegawai\DataPengajuanLembur;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class RiwayatLemburController extends Controller
{
    public function index(User $pegawai)
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $Rlembur = DataPengajuanLembur::where('nip', $pegawai->nip)
            ->orderByDesc('tanggal')
            ->paginate($limit);

        $Rlembur->appends(request()->all());
        $Rlembur = LemburPengajuanResource::collection($Rlembur);
        return inertia('Pegawai/Lembur/index', compact('pegawai', 'Rlembur'));
    }

    public function add(User $pegawai)
    {
        $Rlembur = null;
        $for = 0;
        $data['data'] = $Rlembur;
        $data['view'] = view('pages.pegawai.pegawai.datariwayat.lembur.add',compact('pegawai', 'Rlembur','for'))->render();
        return response()->json($data);
        // return view('pages.pegawai.pegawai.datariwayat.lembur.add',compact('pegawai', 'Rlembur'));
        // return inertia('Pegawai/Lembur/Add', compact('pegawai', 'Rlembur'));
    }

    public function edit(User $pegawai, DataPengajuanLembur $Rlembur)
    {
        // return view('pages.pegawai.pegawai.datariwayat.Lembur.edit',compact('pegawai', 'Rlembur'));
        // return inertia('Pegawai/Lembur/Add', compact('pegawai', 'Rlembur'));
        $for = 1;
        $data['data'] = $Rlembur;
        $data['view'] = view('pages.pegawai.pegawai.datariwayat.lembur.add',compact('pegawai', 'Rlembur','for'))->render();
        return response()->json($data);
    }

    public function delete(User $pegawai, DataPengajuanLembur $Rlembur)
    {
        tambah_log($pegawai->nip, "App\Pegawai\DataPengajuanLembur", $Rlembur->id, 'dihapus');
        $cr = $Rlembur->delete();
        if ($cr) {
            return redirect(route('pegawai.lembur.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('pegawai.lembur.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store(User $pegawai)
    {
        $rules = [
            'nomor_surat' => 'required',
            'tanggal_surat' => 'nullable',
            'tanggal' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'keterangan' => 'nullable',
        ];

        if (request()->file('file')) {
            $rules['file'] = 'mimes:pdf|max:2048';
        }

        $data = request()->validate($rules);
        $data['tanggal'] = date("Y-m-d",strtotime($data["tanggal"]));
        $data['tanggal_surat'] =  date("Y-m-d",strtotime($data["tanggal_surat"]));

        $id = request('id');
        if ($id) {
            if (request()->file('file')) {
                $file = DataPengajuanLembur::where('id', $id)->where('nip', $pegawai->nip)->value('file');
                if ($file) {
                    @unlink($file);
                }
            }
            tambah_log($pegawai->nip, "App\Pegawai\DataPengajuanLembur", $id, 'diubah');
        }

        if (request()->file('file')) {
            // $data['file'] = request()->file('file')->storeAs($pegawai->nip, $pegawai->nip . "-lembur-" . request('nomor_surat') . ".pdf");
            $dir = 'data_pegawai/'.$pegawai->nip.'/lembur';
            $data['file'] = $dir.'/'.uploadFile($dir,request()->file('file'));
        }

        $cr = DataPengajuanLembur::updateOrCreate(
            [
                'id' => $id,
                'nip' => $pegawai->nip,
            ],
            $data
        );

        if (!$id) {
            tambah_log($pegawai->nip, "App\Pegawai\DataPengajuanLembur", $cr->id, 'ditambahkan');
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

        $Rlembur = DataPengajuanLembur::where('nip', $pegawai)
            ->orderByDesc('tanggal')
            ->get();
        $Rlembur = LemburPengajuanResource::collection($Rlembur);
        return $dataTables->of($Rlembur)
            ->addColumn('tanggal', function ($row) {
                return  tanggal_indo($row['tanggal']) ;
            })
            ->addColumn('jam_mulai', function ($row) {
                return  $row['jam_mulai'] ;
            })
            ->addColumn('jam_selesai', function ($row) {
                return  $row['jam_selesai'] ;
            })
            ->addColumn('keterangan', function ($row) {
                return  $row['keterangan'] ;
            })
            ->addColumn('file', function ($row) {
                if(is_null($row['file'])){
                        return "-";
                }
                return '<a class="badge badge-primary badge-outline" href="' . $row['file'] . '">Lihat Berkas</a>';
            })
            ->addColumn('opsi', function ($row) {

                $html = "<a class='me-2 edit' tooltip='Edit' href='" . route('pegawai.lembur.edit', ['pegawai' => $row['nip'], 'Rlembur' => $row['id']]) . "'>" . icons('pencil') . "</a>";
                $html .= "<a class='text-danger delete' tooltip='Hapus' href='" . route('pegawai.lembur.delete', ['pegawai' => $row['nip'], 'Rlembur' => $row['id']]) . "'>" . icons('trash') . "</a>";
                return $html;
            })
            ->rawColumns(['opsi', 'file'])
            ->addIndexColumn()->toJson();
    }
}
