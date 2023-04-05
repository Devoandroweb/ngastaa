<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\RiwayatOrganisasiResource;
use App\Models\Pegawai\RiwayatOrganisasi;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class RiwayatOrganisasiController extends Controller
{
    public function index(User $pegawai)
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $Rorganisasi = RiwayatOrganisasi::where('nip', $pegawai->nip)
            ->orderByDesc('tanggal_mulai')
            ->paginate($limit);

        $Rorganisasi->appends(request()->all());
        $Rorganisasi = RiwayatOrganisasiResource::collection($Rorganisasi);
        return inertia('Pegawai/Organisasi/index', compact('pegawai', 'Rorganisasi'));
    }

    public function add(User $pegawai)
    {
        $Rorganisasi = null;
        $for = 0;
        // $view = view('pages.pegawai.pegawai.DataLainnya.Organisasi.add',compact('pegawai', 'Rorganisasi', 'for'))->render();
        // return response()->json(["view"=>$view]);
        $data['data'] = $Rorganisasi;
        $data['view'] = view('pages.pegawai.pegawai.datalainnya.organisasi.add',compact('pegawai', 'Rorganisasi', 'for'))->render();
        return response()->json($data);
    
        // return inertia('Pegawai/Organisasi/Add', compact('pegawai', 'Rorganisasi'));
    }

    public function edit(User $pegawai, RiwayatOrganisasi $Rorganisasi)
    {
        $for = 1;
        $data['data'] = $Rorganisasi;
        $data['view'] = view('pages.pegawai.pegawai.datalainnya.organisasi.add',compact('pegawai', 'Rorganisasi', 'for'))->render();
        return response()->json($data);
        // return inertia('Pegawai/Organisasi/Add', compact('pegawai', 'Rorganisasi'));
    }

    public function delete(User $pegawai, RiwayatOrganisasi $Rorganisasi)
    {
        $cr = $Rorganisasi->delete();
        if ($cr) {
            return redirect(route('pegawai.organisasi.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('pegawai.organisasi.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store(User $pegawai)
    {
        $rules = [
            'nama_organisasi' => 'required',
            'jenis_organisasi' => 'required',
            'jabatan' => 'nullable',
            'tanggal_mulai' => 'nullable',
            'tanggal_selesai' => 'nullable',
            'nama_pimpinan' => 'nullable',
            'tempat' => 'nullable',
        ];

        if (request()->file('file')) {
            $rules['file'] = 'mimes:pdf|max:2048';
        }

        $data = request()->validate($rules);
        $data['tanggal_mulai'] = date("Y-m-d",strtotime(str_replace("/","-", $data["tanggal_mulai"])));
        $data['tanggal_selesai'] =  date("Y-m-d",strtotime(str_replace("/","-", $data["tanggal_selesai"])));
        
        $id = request('id');
        if ($id) {
            if (request()->file('file')) {
                $file = RiwayatOrganisasi::where('id', $id)->where('nip', $pegawai->nip)->value('file');
                if ($file) {
                    @unlink($file);
                }
            }
        }

        if (request()->file('file')) {
            // $data['file'] = request()->file('file')->storeAs($pegawai->nip, $pegawai->nip . "-organisasi-" . request('no_sertifikat') . ".pdf");
            $dir = 'data_pegawai/'.$pegawai->nip.'/organisasi';
            $data['file'] = $dir.'/'.uploadFile($dir,request()->file('file'));
        }

        $cr = RiwayatOrganisasi::updateOrCreate(
            [
                'id' => $id,
                'nip' => $pegawai->nip,
            ],
            $data
        );

        // dd($data);
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
        $Rorganisasi = RiwayatOrganisasi::where('nip', $pegawai)
            ->orderByDesc('tanggal_mulai')
            ->get();
            // dd($Rorganisasi);
        // $Rorganisasi = RiwayatOrganisasiResource::collection($Rorganisasi);
        return $dataTables->of($Rorganisasi)

        ->addColumn('nama_organisasi', function ($row) {
            return  $row['nama_organisasi'] ;
        })
        ->addColumn('jenis_organisasi', function ($row) {
            return  $row['jenis_organisasi'] ;
        })
        ->addColumn('jabatan', function ($row) {
            return  $row['jabatan'] ;
        })
        ->addColumn('tanggal_mulai', function ($row) {
            return tanggal_indo($row['tanggal_mulai']) ;
        })
        ->addColumn('file', function ($row) {
            if(is_null($row['file'])){
                    return "-";
            }
            return '<a class="badge badge-primary badge-outline" href="' . $row['file'] . '">Lihat Berkas</a>';
        })
        ->addColumn('opsi', function ($row) {

            $html = "<a class='me-2 edit' tooltip='Edit' href='" . route('pegawai.organisasi.edit', ['pegawai' => $row['nip'], 'Rorganisasi' => $row['id']]) . "'>" . icons('pencil') . "</a>";
            $html .= "<a class='text-danger delete' tooltip='Hapus' href='" . route('pegawai.organisasi.delete', ['pegawai' => $row['nip'], 'Rorganisasi' => $row['id']]) . "'>" . icons('trash') . "</a>";
            return $html;
        })
        ->rawColumns(['opsi', 'tempat_lahir', 'file'])
        ->addIndexColumn()->toJson();
    }
}
