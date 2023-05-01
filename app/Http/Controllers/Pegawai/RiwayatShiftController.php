<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\RiwayatShiftResource;
use App\Models\Pegawai\RiwayatShift;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class RiwayatShiftController extends Controller
{
    public function index(User $pegawai)
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $Rshift = RiwayatShift::where('nip', $pegawai->nip)
            ->orderByDesc('created_at')
            ->whereRaw("(status = 99 OR status = 1)")
            ->paginate($limit);

        $Rshift->appends(request()->all());
        $Rshift = RiwayatShiftResource::collection($Rshift);
        return inertia('Pegawai/Shift/index', compact('pegawai', 'Rshift'));
    }

    public function add(User $pegawai)
    {
        $Rshift = null;
        $for = 0;
        $data['data'] = $Rshift;
        $data['view'] = view('pages.pegawai.pegawai.datariwayat.shift.add',compact('pegawai', 'Rshift', 'for'))->render();
        return response()->json($data);
        // return view('pages.pegawai.pegawai.datariwayat.shift.add',compact('pegawai', 'Rshift'));
        // return inertia('Pegawai/Shift/Add', compact('pegawai', 'Rshift'));
    }

    public function edit(User $pegawai, RiwayatShift $Rshift)
    {
        // return view('pages.pegawai.pegawai.datariwayat.Shift.edit',compact('pegawai', 'Rshift'));
        // return inertia('Pegawai/Shift/Add', compact('pegawai', 'Rshift'));
        
        $for = 1;
        $data['data'] = $Rshift;
        $data['view'] = view('pages.pegawai.pegawai.datariwayat.shift.add',compact('pegawai', 'Rshift', 'for'))->render();
        return response()->json($data);
    }

    public function delete(User $pegawai, RiwayatShift $Rshift)
    {
        tambah_log($pegawai->nip, "App\Pegawai\RiwayatShift", $Rshift->id, 'dihapus');
        $cr = $Rshift->delete();
        if ($cr) {
            return redirect(route('pegawai.shift.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('pegawai.shift.index', $pegawai->nip))->with([
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
            'kode_shift' => 'required',
            'is_akhir' => 'required',
            'keterangan' => 'nullable',
        ];

        if (request()->file('file')) {
            $rules['file'] = 'mimes:pdf|max:2048';
        }

        $data = request()->validate($rules);
        $data['tanggal_surat'] = normalDateSystem(request("tanggal_surat"));
        // $data["status"] = "99";

        $id = request('id');
        if ($id) {
            if (request()->file('file')) {
                $file = RiwayatShift::where('id', $id)->where('nip', $pegawai->nip)->value('file');
                if ($file) {
                    @unlink($file);
                }
            }
            tambah_log($pegawai->nip, "App\Pegawai\RiwayatShift", $id, 'diubah');
        }

        // upload file
        if (request()->file('file')) {
            $file = RiwayatShift::where('id', $id)->where('nip', $pegawai->nip)->value('file');
            $dir = 'data_pegawai/'.$pegawai->nip.'/shift';
            if ($file) {
                @unlink($dir."/".$file);
            }
            $data['file'] = $dir.'/'.uploadFile($dir,request()->file('file'));
        }

        // dd($data);
        
        
        if(request()->query('front')){
            $data['nip'] = $pegawai->nip;
            $data['is_akhir'] = 1;
            $data['status'] = 1;
            RiwayatShift::where('nip',$pegawai->nip)->update(['is_akhir' => 0]);
            $cr = RiwayatShift::create($data);
            if (!$id) {
                tambah_log($pegawai->nip, "App\Pegawai\RiwayatShift", $cr->id, 'ditambahkan');
            }
            if($cr){
                return redirect(route('pegawai.pegawai.index'))->with([
                    'type' => 'success',
                    'messages' => "Berhasil, memberikan shift!"
                ]);
            }else{
                return redirect(route('pegawai.pegawai.index'))->with([
                    'type' => 'error',
                    'messages' => "Gagal, memberikan shift!"
                ]);
            }
        }
        $cr = RiwayatShift::updateOrCreate(
            [
                'id' => $id,
                'nip' => $pegawai->nip,
            ],
            $data
        );
        if (!$id) {
            tambah_log($pegawai->nip, "App\Pegawai\RiwayatShift", $cr->id, 'ditambahkan');
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

        $Rshift = RiwayatShift::where('nip', $pegawai)
            ->orderByDesc('created_at')
            ->whereRaw("(status = 99 OR status = 1)")
            ->get();
        $Rshift = RiwayatShiftResource::collection($Rshift);
        return $dataTables->of($Rshift)
        
            ->addColumn('nama', function ($row) {
                if($row['shift']){
                    return (($row->is_akhir == 1)?'<i class="bi bi-bookmark-star-fill text-danger fs-4"></i>' : '').$row['shift']['nama'];
                }
                return  $row['shift']['nama'] ;
            })
            ->addColumn('nomor_surat', function ($row) {
                return  $row['nomor_surat'] ;
            })
            ->addColumn('tanggal_surat', function ($row) {
                return tanggal_indo($row['tanggal_surat']) ;
            })
            ->addColumn('keterangan', function ($row) {
                return  $row['keterangan'];
            })
            ->addColumn('file', function ($row) {
                if(is_null($row['file'])){
                        return "-";
                }

                return '<a class="badge badge-primary badge-outline" href="' . $row['file'] . '">Lihat Berkas</a>';
            })
            ->addColumn('opsi', function ($row) {

                $html = "<a class='me-2 edit' tooltip='Edit' href='" . route('pegawai.shift.edit', ['pegawai' => $row['nip'], 'Rshift' => $row['id']]) . "'>" . icons('pencil') . "</a>";
                $html .= "<a class='text-danger delete' tooltip='Hapus' href='" . route('pegawai.shift.delete', ['pegawai' => $row['nip'], 'Rshift' => $row['id']]) . "'>" . icons('trash') . "</a>";
                return $html;
            })
            ->rawColumns(['opsi', 'file','nama'])
            ->addIndexColumn()->toJson();
    }
}
