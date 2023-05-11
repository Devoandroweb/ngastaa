<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\RiwayatKursusResource;
use App\Models\Pegawai\RiwayatKursus;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class RiwayatKursusController extends Controller
{
    public function index(User $pegawai)
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $Rkursus = RiwayatKursus::where('nip', $pegawai->nip)
            ->orderByDesc('tanggal_mulai')
            ->paginate($limit);

        $Rkursus->appends(request()->all());
        $Rkursus = RiwayatKursusResource::collection($Rkursus);
        return inertia('Pegawai/Kursus/index', compact('pegawai', 'Rkursus'));
    }

    public function add(User $pegawai)
    {
        $Rkursus = null;
        // return inertia('Pegawai/Kursus/Add', compact('pegawai', 'Rkursus'));
        // return view('pages.pegawai.pegawai.datariwayat.kursus.add',compact('pegawai', 'Rkursus'));
        $for = 0;
        $data['data'] = $Rkursus;
        $data['view'] = view('pages.pegawai.pegawai.datariwayat.kursus.add',compact('pegawai', 'Rkursus', 'for'))->render();
        return response()->json($data);
    }

    public function edit(User $pegawai, RiwayatKursus $Rkursus)
    {
        // return inertia('Pegawai/Kursus/Add', compact('pegawai', 'Rkursus'));
        // return view('pages.pegawai.pegawai.datariwayat.Kursus.edit',compact('pegawai', 'Rkursus'));
        $for = 1;
        $data['data'] = $Rkursus;
        $data['view'] = view('pages.pegawai.pegawai.datariwayat.kursus.add',compact('pegawai', 'Rkursus', 'for'))->render();
        return response()->json($data);
    }
    public function delete(User $pegawai, RiwayatKursus $Rkursus)
    {
        $cr = $Rkursus->delete();
        if ($cr) {
            return response()->json(["status"=>true,"msg"=>"Berhasil, dihapus!"]);
        } else {
            return response()->json(["status"=>false,"msg"=>"Gagal, dihapus!"]);
        }
    }

    public function store(User $pegawai)
    {
        $rules = [
            'kode_kursus' => 'required',
            'tempat' => 'required',
            'pelaksana' => 'required',
            'angkatan' => 'required',
            'tanggal_mulai' => 'nullable',
            'tanggal_selesai' => 'nullable',
            'jumlah_jp' => 'nullable',
            'no_sertifikat' => 'required',
            'tanggal_sertifikat' => 'nullable',
        ];

        if (request()->file('file')) {
            $rules['file'] = 'mimes:pdf|max:2048';
        }

        $data = request()->validate($rules);
        $data['tanggal_mulai'] = normalDateSystem(request("tanggal_mulai"));
        $data['tanggal_selesai'] =  normalDateSystem(request("tanggal_selesai"));
        $data['tanggal_sertifikat'] =  normalDateSystem(request("tanggal_sertifikat"));
        $id = request('id');
        if ($id) {
            if (request()->file('file')) {
                $file = RiwayatKursus::where('id', $id)->where('nip', $pegawai->nip)->value('file');
                if ($file) {
                    @unlink($file);
                }
            }
        }

        // upload file
        if (request()->file('file')) {
            $file = RiwayatKursus::where('id', $id)->where('nip', $pegawai->nip)->value('file');
            $dir = 'data_pegawai/'.$pegawai->nip.'/kursus';
            if ($file) {
                @unlink($dir."/".$file);
            }
            $data['file'] = $dir.'/'.uploadFile($dir,request()->file('file'));
        }

        $cr = RiwayatKursus::updateOrCreate(
            [
                'id' => $id,
                'nip' => $pegawai->nip,
            ],
            $data
        );

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
        $Rkursus = RiwayatKursus::where('nip', $pegawai)
            ->orderByDesc('tanggal_mulai')
            ->get();

        // $Rkursus = RiwayatKursusResource::collection($Rkursus);
        return $dataTables->of($Rkursus)
        ->addColumn('nama', function ($row) {
            return  $row['kursus']['nama'];
        })
        ->addColumn('tempat', function ($row) {
            return  $row['tempat'];
        })
        ->addColumn('pelaksana', function ($row) {
            return  $row['pelaksana'];
        })
        ->addColumn('no_sertifikat', function ($row) {
            return  $row['no_sertifikat'];
        })
        ->addColumn('tanggal_sertifikat', function ($row) {
            return tanggal_indo($row['tanggal_sertifikat']) ;
        })
        ->addColumn('file', function ($row) {
            if(is_null($row['file'])){
                    return "-";
            }
            return '<a class="badge badge-primary badge-outline" href="' . $row['file'] . '">Lihat Berkas</a>';
        })
        ->addColumn('opsi', function ($row) {
            $html = "<a class='me-2 edit' tooltip='Edit' href='" . route('pegawai.kursus.edit', ['pegawai' => $row['nip'], 'Rkursus' => $row['id']]) . "'>" . icons('pencil') . "</a>";
            $html .= "<a class='text-danger delete' tooltip='Hapus' href='" . route('pegawai.kursus.delete', ['pegawai' => $row['nip'], 'Rkursus' => $row['id']]) . "'>" . icons('trash') . "</a>";
            return $html;
        })
        ->rawColumns(['opsi', 'file'])
        ->addIndexColumn()->toJson();
    }
}
