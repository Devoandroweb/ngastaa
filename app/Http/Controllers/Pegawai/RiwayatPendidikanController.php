<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\RiwayatPendidikanResource;
use App\Models\Pegawai\RiwayatPendidikan;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class RiwayatPendidikanController extends Controller
{
    public function index(User $pegawai)
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $Rpendidikan = RiwayatPendidikan::where('nip', $pegawai->nip)
            ->orderByDesc('kode_pendidikan')
            ->paginate($limit);

        $Rpendidikan->appends(request()->all());
        $Rpendidikan = RiwayatPendidikanResource::collection($Rpendidikan);
        return inertia('Pegawai/Pendidikan/index', compact('pegawai', 'Rpendidikan'));
    }

    public function add(User $pegawai)
    {
    
        // return inertia('Pegawai/Pendidikan/Add', compact('pegawai', 'Rpendidikan'));
        // return view('pages.pegawai.pegawai.datariwayat.pendidikan.add',compact('pegawai', 'Rpendidikan'));
        $for = 0;
        $Rpendidikan = null;
        $data['data'] = $Rpendidikan;
        $data['view'] = view('pages.pegawai.pegawai.datariwayat.pendidikan.add',compact('pegawai', 'Rpendidikan', 'for'))->render();
        return response()->json($data);
    
    }

    public function edit(User $pegawai, RiwayatPendidikan $Rpendidikan)
    {
  
        $for = 1;
        $data['data'] = $Rpendidikan;
        $data['view'] = view('pages.pegawai.pegawai.datariwayat.pendidikan.add',compact('pegawai', 'Rpendidikan', 'for'))->render();
        return response()->json($data);
        // return inertia('Pegawai/Pendidikan/Add', compact('pegawai', 'Rpendidikan'));
    }

    public function delete(User $pegawai, RiwayatPendidikan $Rpendidikan)
    {
        $cr = $Rpendidikan->delete();
        if ($cr) {
            return redirect(route('pegawai.jabatan.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('pegawai.jabatan.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function akhir(User $pegawai, Riwayatpendidikan $Rpendidikan)
    {
        if ($Rpendidikan->file) {
            Storage::delete($Rpendidikan->file);
        }
        RiwayatPendidikan::where('nip', $pegawai->nip)->update(['is_akhir' => 0]);
        $cr = $Rpendidikan->update(['is_akhir' => 1]);
        if ($cr) {
            return redirect(route('pegawai.jabatan.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, diperbaharui!"
            ]);
        } else {
            return redirect(route('pegawai.jabatan.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, diperbaharui!"
            ]);
        }
    }

    public function store(User $pegawai)
    {
        $rules = [
            'kode_pendidikan' => 'required',
            'kode_jurusan' => 'nullable',
            'nomor_ijazah' => 'required',
            'nama_sekolah' => 'required',
            'tanggal_lulus' => 'required',
            'gelar_depan' => 'nullable',
            'gelar_belakang' => 'nullable',
            'is_akhir' => 'nullable',
        ];

        if (request()->file('file')) {
            $rules['file'] = 'mimes:pdf|max:2048';
        }

        $data = request()->validate($rules);
        $data['tanggal_lulus'] = date("Y-m-d",strtotime(str_replace("/","-", $data["tanggal_lulus"])));

        if (request('is_akhir') == 1) {
            RiwayatPendidikan::where('nip', $pegawai->nip)->update(['is_akhir' => 0]);
        }

        $id = request('id');
        if ($id) {
            if (request()->file('file')) {
                $file = RiwayatPendidikan::where('id', $id)->where('nip', $pegawai->nip)->value('file');
                if ($file) {
                    Storage::delete($file);
                }
            }
        }

        if (request()->file('file')) {
            $data['file'] = request()->file('file')->storeAs($pegawai->nip, $pegawai->nip . "-pendidikan-" . request('nomor_ijazah') . request('kode_pendidikan') . ".pdf");
        }

        $cr = RiwayatPendidikan::updateOrCreate(
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
        $Rpendidikan = RiwayatPendidikan::where('nip', $pegawai)
            ->orderByDesc('kode_pendidikan')
            ->get();

        // $Rpendidikan = RiwayatPendidikanResource::collection($Rpendidikan);
        return $dataTables->of($Rpendidikan)
        ->addColumn('nama_sekolah', function ($row) {
            return  $row['nama_sekolah'];
        })
        ->addColumn('nomor_ijazah', function ($row) {
            return  $row['nomor_ijazah'];
        })
        ->addColumn('tanggal_lulus', function ($row) {
            return tanggal_indo($row['tanggal_lulus']) ;
        })
        ->addColumn('tingkat', function ($row) {
            return (($row['is_akhir'] == 1)?'<i class="bi bi-bookmark-star-fill text-danger fs-4"></i>' : '').$row['pendidikan']['nama'];
        })->addColumn('jurusan', function ($row) {
            return (($row['is_akhir'] == 1)?'<i class="bi bi-bookmark-star-fill text-danger fs-4"></i>' : '').$row['pendidikan']['nama'];
        })->addColumn('file', function ($row) {

            return '<a class="badge badge-primary badge-outline" href="' . $row['file'] . '">Lihat Berkas</a>';
        })
        ->addColumn('opsi', function ($row) {

            $html = "<a class='me-2 edit' tooltip='Edit' href='" . route('pegawai.pendidikan.edit', ['pegawai' => $row['nip'], 'Rpendidikan' => $row['id']]) . "'>" . icons('pencil') . "</a>";
            $html .= "<a class='text-danger delete' tooltip='Hapus' href='" . route('pegawai.pendidikan.delete', ['pegawai' => $row['nip'], 'Rpendidikan' => $row['id']]) . "'>" . icons('trash') . "</a>";
            return $html;
        })
        ->rawColumns(['opsi', 'file', 'is_akhir', 'jurusan','tingkat'])
        ->addIndexColumn()->toJson();
    }
    
}
