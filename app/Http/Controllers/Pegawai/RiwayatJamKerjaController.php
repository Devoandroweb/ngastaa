<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\RiwayatJamKerjaResource;
use App\Models\Pegawai\RiwayatJamKerja;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class RiwayatJamKerjaController extends Controller
{
    public function index(User $pegawai)
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $RJamKerja = RiwayatJamKerja::where('nip', $pegawai->nip)
            ->orderByDesc('created_at')
            ->whereRaw("(status = 99 OR status = 1)")
            ->paginate($limit);

        $RJamKerja->appends(request()->all());
        $RJamKerja = RiwayatJamKerjaResource::collection($RJamKerja);
        return inertia('Pegawai/jamkerja/index', compact('pegawai', 'RJamKerja'));
    }

    public function add(User $pegawai)
    {
        $RJamKerja = null;
        $for = 0;
        $data['data'] = $RJamKerja;
        $data['view'] = view('pages.pegawai.pegawai.datariwayat.jam_kerja.add',compact('pegawai', 'RJamKerja', 'for'))->render();
        return response()->json($data);
        // return view('pages.pegawai.pegawai.datariwayat.jam_kerja.add',compact('pegawai', 'RJamKerja'));
        // return inertia('Pegawai/jamkerja/Add', compact('pegawai', 'RJamKerja'));
    }

    public function edit(User $pegawai, RiwayatJamKerja $RJamKerja)
    {
        // return view('pages.pegawai.pegawai.datariwayat.jam_kerja.edit',compact('pegawai', 'RJamKerja'));
        // return inertia('Pegawai/jamkerja/Add', compact('pegawai', 'RJamKerja'));

        $for = 1;
        $data['data'] = $RJamKerja;
        $data['view'] = view('pages.pegawai.pegawai.datariwayat.jam_kerja.add',compact('pegawai', 'RJamKerja', 'for'))->render();
        return response()->json($data);
    }

    public function delete(User $pegawai, RiwayatJamKerja $RJamKerja)
    {
        tambah_log($pegawai->nip, "App\Pegawai\RiwayatJamKerja", $RJamKerja->id, 'dihapus');
        $cr = $RJamKerja->delete();
        if ($cr) {
            return redirect(route('pegawai.jam_kerja.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('pegawai.jam_kerja.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store(User $pegawai)
    {
        $rules = [
            'kode_jam_kerja' => 'required',
            'is_akhir' => 'required',
        ];

        if (request()->file('file')) {
            $rules['file'] = 'mimes:pdf|max:2048';
        }

        $data = request()->validate($rules);
        // $data["status"] = "99";

        $id = request('id');
        if ($id) {
            if (request()->file('file')) {
                $file = RiwayatJamKerja::where('id', $id)->where('nip', $pegawai->nip)->value('file');
                if ($file) {
                    @unlink($file);
                }
            }
            tambah_log($pegawai->nip, "App\Pegawai\RiwayatJamKerja", $id, 'diubah');
        }

        // upload file
        if (request()->file('file')) {
            $file = RiwayatJamKerja::where('id', $id)->where('nip', $pegawai->nip)->value('file');
            $dir = 'data_pegawai/'.$pegawai->nip.'/jamkerja';
            if ($file) {
                @unlink($dir."/".$file);
            }
            $data['file'] = $dir.'/'.uploadFile($dir,request()->file('file'));
        }

        // dd($data);
        // if(role('owner')){
        // }
        $data['status'] = 1;

        if(request()->query('front')){
            $data['nip'] = $pegawai->nip;
            $data['is_akhir'] = 1;
            $data['status'] = 1;
            RiwayatJamKerja::where('nip',$pegawai->nip)->update(['is_akhir' => 0]);
            $cr = RiwayatJamKerja::create($data);
            if (!$id) {
                tambah_log($pegawai->nip, "App\Pegawai\RiwayatJamKerja", $cr->id, 'ditambahkan');
            }
            if($cr){
                return redirect(route('pegawai.pegawai.index'))->with([
                    'type' => 'success',
                    'messages' => "Berhasil, memberikan jamkerja!"
                ]);
            }else{
                return redirect(route('pegawai.pegawai.index'))->with([
                    'type' => 'error',
                    'messages' => "Gagal, memberikan jamkerja!"
                ]);
            }
        }
        $cr = RiwayatJamKerja::updateOrCreate(
            [
                'id' => $id,
                'nip' => $pegawai->nip,
            ],
            $data
        );
        if (!$id) {
            tambah_log($pegawai->nip, "App\Pegawai\RiwayatJamKerja", $cr->id, 'ditambahkan');
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

        $RJamKerja = RiwayatJamKerja::where('nip', $pegawai)
            ->orderByDesc('created_at')
            ->whereRaw("(status = 99 OR status = 1)")
            ->get();
        $RJamKerja = RiwayatJamKerjaResource::collection($RJamKerja);
        return $dataTables->of($RJamKerja)

            ->addColumn('nama', function ($row) {
                // dd($row->jamKerja);
                if($row->jamKerja != null){
                    return (($row->is_akhir == 1)?'<i class="bi bi-bookmark-star-fill text-danger fs-4"></i>' : '').$row['jamkerja']['nama'];
                }
                return  $row->jamKerja?->nama ;
            })
            ->addColumn('is_akhir', function ($row) {
                return '<a class="badge badge-primary badge-outline" href="' . $row['file'] . '">Lihat Berkas</a>';
            })
            ->addColumn('opsi', function ($row) {

                $html = "<a class='me-2 edit' tooltip='Edit' href='" . route('pegawai.jam_kerja.edit', ['pegawai' => $row['nip'], 'RJamKerja' => $row['id']]) . "'>" . icons('pencil') . "</a>";
                $html .= "<a class='text-danger delete' tooltip='Hapus' href='" . route('pegawai.jam_kerja.delete', ['pegawai' => $row['nip'], 'RJamKerja' => $row['id']]) . "'>" . icons('trash') . "</a>";
                return $html;
            })
            ->rawColumns(['opsi', 'file','nama'])
            ->addIndexColumn()->toJson();
    }
}
