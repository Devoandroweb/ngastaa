<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\RiwayatCutiResource;
use App\Models\Pegawai\RiwayatCuti;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;
class RiwayatCutiController extends Controller
{
    public function index(User $pegawai)
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $Rcuti = RiwayatCuti::where('nip', $pegawai->nip)
            ->orderByDesc('tanggal_mulai')
            ->paginate($limit);

        $Rcuti->appends(request()->all());
        $Rcuti = RiwayatCutiResource::collection($Rcuti);
        return inertia('Pegawai/Cuti/index', compact('pegawai', 'Rcuti'));
    }

    public function add(User $pegawai)
    {
        
        // return view('pages.pegawai.pegawai.datariwayat.Cuti.add',compact('pegawai', 'Rcuti'));
        // return inertia('Pegawai/Cuti/Add', compact('pegawai', 'Rcuti'));
        $Rcuti = null;
        $for = 0;
        $data['data'] = $Rcuti;
        $data['view'] = view('pages.pegawai.pegawai.datariwayat.cuti.add',compact('pegawai', 'Rcuti','for'))->render();
        return response()->json($data);
        
    }

    public function edit(User $pegawai, RiwayatCuti $Rcuti)
    {
        // return inertia('Pegawai/Cuti/Add', compact('pegawai', 'Rcuti'));
        // return view('pages.pegawai.pegawai.datariwayat.Cuti.edit',compact('pegawai', 'Rcuti'));
        
        $for = 1;
        $data['data'] = $Rcuti;
        $data['view'] = view('pages.pegawai.pegawai.datariwayat.Cuti.add',compact('pegawai', 'Rcuti','for'))->render();
        return response()->json($data);
    }

    public function delete(User $pegawai, RiwayatCuti $Rcuti)
    {
        $cr = $Rcuti->delete();
        if ($cr) {
            return redirect(route('pegawai.cuti.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('pegawai.cuti.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store(User $pegawai)
    {
        $rules = [
            'kode_cuti' => 'required',
            'nomor_surat' => 'required',
            'tanggal_surat' => 'required',
            'tanggal_mulai' => 'nullable',
            'tanggal_selesai' => 'nullable',
        ];

        if (request()->file('file')) {
            $rules['file'] = 'mimes:pdf|max:2048';
        }

        $data = request()->validate($rules);

        $id = request('id');
        if ($id) {
            if (request()->file('file')) {
                $file = RiwayatCuti::where('id', $id)->where('nip', $pegawai->nip)->value('file');
                if ($file) {
                    @unlink($file);
                }
            }
        }

        // upload file
        if (request()->file('file')) {
            $file = RiwayatCuti::where('id', $id)->where('nip', $pegawai->nip)->value('file');
            $dir = 'data_pegawai/'.$pegawai->nip.'/perizinan';
            if ($file) {
                @unlink($dir."/".$file);
            }
            $data['file'] = $dir.'/'.uploadFile($dir,request()->file('file'));
        }
        
        $data['tanggal_surat'] = normalDateSystem(request('tanggal_surat'));
        $data['tanggal_mulai'] = normalDateSystem(request('tanggal_mulai'));
        $data['tanggal_selesai'] = normalDateSystem(request('tanggal_selesai'));
        
        $cr = RiwayatCuti::updateOrCreate(
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

        // if ($cr) {
        //     return redirect(route('pegawai.cuti.index', $pegawai->nip))->with([
        //         'type' => 'success',
        //         'messages' => "Berhasil, diperbaharui!"
        //     ]);
        // } else {
        //     return redirect(route('pegawai.cuti.index', $pegawai->nip))->with([
        //         'type' => 'error',
        //         'messages' => "Gagal, diperbaharui!"
        //     ]);
        // }
    }
    public function datatable($pegawai, DataTables $dataTables)
    {
        
        $Rcuti = RiwayatCuti::where('nip', $pegawai)->with('cuti')->has('cuti')
            ->orderByDesc('tanggal_mulai')
            ->get();
        $Rcuti = RiwayatCutiResource::collection($Rcuti);
        // dd($Rcuti);
        return $dataTables->of($Rcuti)
            ->addColumn('cuti', function ($row) {
                if(is_null($row['cuti'])){
                    return "-";
                }
                return  $row['cuti']['nama'] ;
            })
            ->addColumn('tanggal_surat', function ($row) {

                return  tanggal_indo($row['tanggal_surat']) ;
            })
            ->addColumn('tanggal_mulai', function ($row) {

                return  tanggal_indo($row['tanggal_mulai']) ;
            })
            ->addColumn('tanggal_selesai', function ($row) {

                return  tanggal_indo($row['tanggal_selesai']) ;
            })
            ->addColumn('nomor_surat', function ($row) {

                return  $row['nomor_surat'] ;
            })
            ->addColumn('file', function ($row) {
                if(is_null($row['file'])){
                        return "-";
                }
                return '<a class="badge badge-primary badge-outline" href="' . $row['file'] . '">Lihat Berkas</a>';
            })
            ->addColumn('opsi', function ($row) {

                $html = "<a class='me-2 edit' tooltip='Edit' href='" . route('pegawai.cuti.edit', ['pegawai' => $row['nip'], 'Rcuti' => $row['id']]) . "'>" . icons('pencil') . "</a>";
                $html .= "<a class='text-danger delete' tooltip='Hapus' href='" . route('pegawai.cuti.delete', ['pegawai' => $row['nip'], 'Rcuti' => $row['id']]) . "'>" . icons('trash') . "</a>";
                return $html;
            })
            ->rawColumns(['opsi', 'file','cuti','tanggal_surat', 'tanggal_mulai','tanggal_selesai','nomor_surat'])
            ->addIndexColumn()->toJson();
    }
}
