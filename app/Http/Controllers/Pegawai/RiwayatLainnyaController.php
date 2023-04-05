<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\RiwayatLainnyaResource;
use App\Models\Pegawai\RiwayatLainnya;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class RiwayatLainnyaController extends Controller
{

    public function index(User $pegawai)
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $Rlainnya = RiwayatLainnya::where('nip', $pegawai->nip)
            ->orderByDesc('tanggal_sk')
            ->paginate($limit);

        $Rlainnya->appends(request()->all());
        $Rlainnya = RiwayatLainnyaResource::collection($Rlainnya);
        return inertia('Pegawai/Lainnya/index', compact('pegawai', 'Rlainnya'));
    }

    public function add(User $pegawai)
    {
        $Rlainnya = null;
        // return inertia('Pegawai/Lainnya/Add', compact('pegawai', 'Rlainnya'));
        $for = 0;
        $view =  view('pages.pegawai.pegawai.datalainnya.riwayatlainnya.add',compact('pegawai', 'Rlainnya', 'for'))->render();
        return response()->json(["view"=>$view]);
    
    }

    public function edit(User $pegawai, RiwayatLainnya $Rlainnya)
    {
        // return inertia('Pegawai/Lainnya/Add', compact('pegawai', 'Rlainnya'));
        $for = 1;
        $view =  view('pages.pegawai.pegawai.datalainnya.riwayatlainnya.add',compact('pegawai', 'Rlainnya', 'for'))->render();
        return response()->json(["view"=>$view]);
    }

    public function delete(User $pegawai, RiwayatLainnya $Rlainnya)
    {
        $cr = $Rlainnya->delete();
        if ($cr) {
            return redirect(route('pegawai.lainnya.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('pegawai.lainnya.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store(User $pegawai)
    {
        $rules = [
            'kode_lainnya' => 'required',
            'nomor_sk' => 'required',
            'tanggal_sk' => 'required',
        ];

        if (request()->file('file')) {
            $rules['file'] = 'mimes:pdf|max:2048';
        }

        $data = request()->validate($rules);
        $data['tanggal_sk'] =  date("Y-m-d",strtotime(str_replace("/","-", $data["tanggal_sk"])));

        $id = request('id');
        if ($id) {
            if (request()->file('file')) {
                $file = RiwayatLainnya::where('id', $id)->where('nip', $pegawai->nip)->value('file');
                if ($file) {
                    Storage::delete($file);
                }
            }
        }


        if (request()->file('file')) {
            // $data['file'] = request()->file('file')->storeAs($pegawai->nip, $pegawai->nip . "-lainnya-" . request('tanggal_sk') . ".pdf");
            $dir = 'data_pegawai/'.$pegawai->nip.'/lainnya';
            $data['file'] = $dir.'/'.uploadFile($dir,request()->file('file'));
        }

        $cr = RiwayatLainnya::updateOrCreate(
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
    public function datatable($pegawai,DataTables $dataTables){
        $Rlainnya = RiwayatLainnya::where('nip', $pegawai)
            ->orderByDesc('tanggal_sk')
            ->get();
        // $Rlainnya = RiwayatLainnyaResource::collection($Rlainnya);
        return $dataTables->of($Rlainnya)
        ->addColumn('nomor_sk', function ($row) {
            return  $row['nomor_sk'] ;
        })
        ->addColumn('tanggal_sk', function ($row) {
            return  tanggal_indo($row['tanggal_sk']);
        })
        ->addColumn('file', function ($row) {
            if(is_null($row['file'])){
                    return "-";
            }
            return '<a class="badge badge-primary badge-outline" href="' . $row['file'] . '">Lihat Berkas</a>';
        })
        ->addColumn('opsi', function ($row) {

            $html = "<a class='me-2 edit' tooltip='Edit' href='" . route('pegawai.lainnya.edit', ['pegawai' => $row['nip'], 'Rlainnya' => $row['id']]) . "'>" . icons('pencil') . "</a>";
            $html .= "<a class='text-danger delete' tooltip='Hapus' href='" . route('pegawai.lainnya.delete', ['pegawai' => $row['nip'], 'Rlainnya' => $row['id']]) . "'>" . icons('trash') . "</a>";
            return $html;
        })
        ->rawColumns(['opsi', 'tempat_lahir', 'file'])
        ->addIndexColumn()->toJson();
    }
}
