<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\RiwayatBahasaResource;
use App\Models\Pegawai\RiwayatBahasa;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class RiwayatBahasaController extends Controller
{
    public function index(User $pegawai)
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $Rbahasa = RiwayatBahasa::where('nip', $pegawai->nip)
            ->paginate($limit);

        $Rbahasa->appends(request()->all());
        $Rbahasa = RiwayatBahasaResource::collection($Rbahasa);
        return inertia('Pegawai/Bahasa/index', compact('pegawai', 'Rbahasa'));
    }

    public function add(User $pegawai)
    {
        $Rbahasa = null;
        // return inertia('Pegawai/Bahasa/Add', compact('pegawai', 'Rbahasa'));
        $for = 0;
        $view =  view('pages.pegawai.pegawai.datalainnya.penguasaanbahasa.add',compact('pegawai', 'Rbahasa', 'for'))->render();
        return response()->json(["view"=>$view]);
    
    }

    public function edit(User $pegawai, RiwayatBahasa $Rbahasa)
    {

        // return inertia('Pegawai/Bahasa/Add', compact('pegawai', 'Rbahasa'));
        $for = 1;
        $view =  view('pages.pegawai.pegawai.datalainnya.penguasaanbahasa.add',compact('pegawai', 'Rbahasa', 'for'))->render();
        return response()->json(["view"=>$view]);
    }

    public function delete(User $pegawai, RiwayatBahasa $Rbahasa)
    {
        $cr = $Rbahasa->delete();
        if ($cr) {
            return redirect(route('pegawai.bahasa.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('pegawai.bahasa.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store(User $pegawai)
    {
        $rules = [
            'nama_bahasa' => 'required',
            'penguasaan' => 'required',
            'jenis' => 'required',
        ];

        if (request()->file('file')) {
            $rules['file'] = 'mimes:pdf|max:2048';
        }

        $data = request()->validate($rules);

        $id = request('id');
        if ($id) {
            if (request()->file('file')) {
                $file = RiwayatBahasa::where('id', $id)->where('nip', $pegawai->nip)->value('file');
                if ($file) {
                    Storage::delete($file);
                }
            }
        }

        if (request()->file('file')) {
            // $data['file'] = request()->file('file')->storeAs($pegawai->nip, $pegawai->nip . "-bahasa-" . request('no_sertifikat') . ".pdf");
            $dir = 'data_pegawai/'.$pegawai->nip.'/bahasa';
            $data['file'] = $dir.'/'.uploadFile($dir,request()->file('file'));
        }

        $cr = RiwayatBahasa::updateOrCreate(
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
        $Rbahasa = RiwayatBahasa::where('nip', $pegawai)
            ->get();
        // $Rbahasa = RiwayatBahasaResource::collection($Rbahasa);
        return $dataTables->of($Rbahasa)

        ->addColumn('nama_bahasa', function ($row) {
            return  $row['nama_bahasa'];
        })
        ->addColumn('jenis', function ($row) {
            return  ucfirst($row['jenis']);
        })
        ->addColumn('penguasaan', function ($row) {
            return  ucfirst($row['penguasaan']);
        })
        ->addColumn('file', function ($row) {
            if(is_null($row['file'])){
                    return "-";
            }
            return '<a class="badge badge-primary badge-outline" href="' . $row['file'] . '">Lihat Berkas</a>';
        })
        ->addColumn('opsi', function ($row) {
            $html = "<a class='me-2 edit' tooltip='Edit' href='" . route('pegawai.bahasa.edit', ['pegawai' => $row['nip'], 'Rbahasa' => $row['id']]) . "'>" . icons('pencil') . "</a>";
            $html .= "<a class='text-danger delete' tooltip='Hapus' href='" . route('pegawai.bahasa.delete', ['pegawai' => $row['nip'], 'Rbahasa' => $row['id']]) . "'>" . icons('trash') . "</a>";
            return $html;
        })
        ->rawColumns(['opsi', 'tempat_lahir', 'file'])
        ->addIndexColumn()->toJson();
    }
}
