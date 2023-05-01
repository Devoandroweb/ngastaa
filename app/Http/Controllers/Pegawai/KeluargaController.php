<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\KeluargaResource;
use App\Models\Pegawai\Keluarga;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;


class KeluargaController extends Controller
{
    public function index(User $pegawai)
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $keluarga = Keluarga::where('nip', $pegawai->nip)
            ->paginate($limit);

        $keluarga->appends(request()->all());
        $keluarga = KeluargaResource::collection($keluarga);

        $tambah = 0;
        return inertia('Pegawai/Keluarga/index', compact('pegawai', 'keluarga', 'tambah'));
    }

    public function orang_tua(User $pegawai)
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $keluarga = Keluarga::where('nip', $pegawai->nip)
            ->whereIn('status', ['ayah', 'ibu'])
            ->paginate($limit);

        $keluarga->appends(request()->all());
        $keluarga = KeluargaResource::collection($keluarga);

        $tambah = "orang-tua";
        return inertia('Pegawai/Keluarga/index', compact('pegawai', 'keluarga', 'tambah'));
    }

    public function anak(User $pegawai)
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $keluarga = Keluarga::where('nip', $pegawai->nip)
            ->where('status', 'anak')
            ->paginate($limit);

        $keluarga->appends(request()->all());
        $keluarga = KeluargaResource::collection($keluarga);

        $tambah = "anak";
        return inertia('Pegawai/Keluarga/index', compact('pegawai', 'keluarga', 'tambah'));
    }

    public function pasangan(User $pegawai)
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $keluarga = Keluarga::where('nip', $pegawai->nip)
            ->whereIn('status', ['suami', 'istri'])
            ->paginate($limit);

        $keluarga->appends(request()->all());
        $keluarga = KeluargaResource::collection($keluarga);

        if ($pegawai->jenis_kelamin == 'laki-laki') {
            $tambah = "istri";
        } else {
            $tambah = "suami";
        }
        return inertia('Pegawai/Keluarga/index', compact('pegawai', 'keluarga', 'tambah'));
    }

    public function add(User $pegawai, $status)
    {
        $keluarga = null;
        $for = 0;
        // return inertia('Pegawai/Keluarga/Add', compact('pegawai', 'keluarga', 'status'));
        // $view =  view('pages/pegawai/pegawai/datakeluarga/semuakeluarga/add',compact('pegawai', 'keluarga', 'status', 'for'))->render();
        $data['data'] = $keluarga;
        $data['view'] = view('pages/pegawai/pegawai/datakeluarga/semuakeluarga/add',compact('pegawai', 'keluarga', 'status', 'for'))->render();
        return response()->json($data);
    }

    public function edit(User $pegawai, $status = null, Keluarga $Rkeluarga)
    {
        $keluarga = $Rkeluarga;
        // dd($keluarga);
        $for = 1;
        // return inertia('Pegawai/Keluarga/Add', compact('pegawai', 'keluarga'));
        // $view = view('pages/pegawai/pegawai/datakeluarga/semuakeluarga/add',compact('pegawai', 'status' ,'keluarga','for'))->render();
        $data['data'] = $keluarga;
        $data['view'] = view('pages/pegawai/pegawai/datakeluarga/semuakeluarga/add',compact('pegawai', 'status' ,'keluarga', 'for'))->render();
        return response()->json($data);
    }

    public function delete(User $pegawai, Keluarga $Rkeluarga)
    {
        // dd($Rkeluarga);
        if ($Rkeluarga->file_ktp) {
            @unlink($Rkeluarga->file_ktp);
        }
        if ($Rkeluarga->file_bpjs) {
            @unlink($Rkeluarga->file_bpjs);
        }
        if ($Rkeluarga->file_akta_kelahiran) {
            @unlink($Rkeluarga->file_akta_kelahiran);
        }
        $cr = $Rkeluarga->delete();
        if ($cr) {
            return response()->json(["status"=>true,"msg"=>"Berhasil, dihapus!"]);
        } else {
            return response()->json(["status"=>false,"msg"=>"Gagal, dihapus!"]);
        }
    }

    public function akhir(User $pegawai, Keluarga $keluarga)
    {
        Keluarga::where('nip', $pegawai->nip)->update(['is_akhir' => 0]);
        $cr = $keluarga->update(['is_akhir' => 1]);
        if ($cr) {
            return redirect(route('pegawai.keluarga.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, diperbaharui!"
            ]);
        } else {
            return redirect(route('pegawai.keluarga.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, diperbaharui!"
            ]);
        }
    }

    public function store(User $pegawai)
    {
        $rules = [
            'status' => 'required',
            'nama' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            // 'status_kehidupan' => 'required',
            'nip_keluarga' => 'nullable',
            'status_pernikahan' => 'nullable',
            'id_ibu' => 'nullable',
            'status_anak' => 'nullable',
            'anak_ke' => 'nullable',
            'jenis_kelamin' => 'nullable',
            'alamat' => 'nullable',
            'nomor_telepon' => 'nullable',
            'nomor_ktp' => 'nullable',
            'nomor_bpjs' => 'nullable',
            'nomor_akta_kelahiran' => 'nullable',
        ];
        if (request()->file('file_ktp')) {
            $rules['file_ktp'] = 'mimes:pdf|max:2048';
        }
        
        if (request()->file('file_bpjs')) {
            $rules['file_bpjs'] = 'mimes:pdf|max:2048';
        }
        if (request()->file('file_akta_kelahiran')) {
            $rules['file_akta_kelahiran'] = 'mimes:pdf|max:2048';
        }
        # ambil extension
        # cek ext, PDF
        
        $data = request()->validate($rules);
        
        $data['tanggal_lahir'] = normalDateSystem(request('tanggal_lahir'));

        if (request('is_akhir') == 1) {
            Keluarga::where('nip', $pegawai->nip)->update(['is_akhir' => 0]);
        }
        
        $id = request('id');
        if ($id) {
            if (request()->file('file_ktp')) {
                $file = Keluarga::where('id', $id)->where('nip', $pegawai->nip)->value('file_ktp');
                if ($file) {
                    @unlink($file);
                }
            }
            if (request()->file('file_bpjs')) {
                $file = Keluarga::where('id', $id)->where('nip', $pegawai->nip)->value('file_bpjs');
                if ($file) {
                    @unlink($file);
                }
            }
            if (request()->file('file_akta_kelahiran')) {
                $file = Keluarga::where('id', $id)->where('nip', $pegawai->nip)->value('file_akta_kelahiran');
                if ($file) {
                    @unlink($file);
                }
            }
        }

        // upload file
        if (request()->file('file_ktp')) {           
            $file = Keluarga::where('id', $id)->where('nip', $pegawai->nip)->value('file_ktp');
            $dir = 'data_pegawai/'.$pegawai->nip.'/keluarga/ktp';
            if ($file) {
                @unlink($dir."/".$file);
            }
            $data['file_ktp'] = $dir.'/'.uploadFile($dir,request()->file('file_ktp'));
        }

        if (request()->file('file_bpjs')) {
            $file = Keluarga::where('id', $id)->where('nip', $pegawai->nip)->value('file_bpjs');
            $dir = 'data_pegawai/'.$pegawai->nip.'/keluarga/bpjs';
            if ($file) {
                @unlink($dir."/".$file);
            }
            $data['file_bpjs'] = $dir.'/'.uploadFile($dir,request()->file('file_bpjs'));
        }
        
        if (request()->file('file_akta_kelahiran')) {
            $file = Keluarga::where('id', $id)->where('nip', $pegawai->nip)->value('file_akta_kelahiran');
            // $data['file_akta_kelahiran'] = request()->file('file_akta_kelahiran')->storeAs($pegawai->nip, $pegawai->nip . "-akta-" . request('status') . ".pdf");
            $dir = 'data_pegawai/'.$pegawai->nip.'/keluarga/akta';
            if ($file) {
                @unlink($dir."/".$file);
            }
            $data['file_akta_kelahiran'] = $dir.'/'.uploadFile($dir,request()->file('file_akta_kelahiran'));
        }
        // dd($data);
        $cr = Keluarga::updateOrCreate(
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

    public function datatable_keluarga(User $pegawai, DataTables $dataTables)
    {
     
        $Rkeluarga = Keluarga::where('nip', $pegawai->nip)
        ->get();
        // dd($Rkeluaga);
        $Rkeluarga = KeluargaResource::collection($Rkeluarga);
        return $dataTables->of($Rkeluarga)
            ->addColumn('nama', function ($row) {
                return $row['nama'];
            })
            ->addColumn('status', function ($row) {
                return $row['status'];
            })
            ->addColumn('tempat_lahir', function ($row) {
                return $row['tempat_lahir']." ". tanggal_indo($row['tanggal_lahir']);
            })
            ->addColumn('file', function ($row) {
                if(is_null($row['file'])){
                        return "-";
                }
                return '<a class="badge badge-primary badge-outline" href="' . storage($row['file']) . '">Lihat Berkas</a>';
            })
            ->addColumn('opsi', function ($row) {

                $html = "<a class='me-2 edit' tooltip='Edit' href='" . route('pegawai.keluarga.edit', ['pegawai' => $row['nip'], "status"=>0 ,'Rkeluarga' => $row['id']]) . "'>" . icons('pencil') . "</a>";
                $html .= "<a class='text-danger delete' tooltip='Hapus' href='" . route('pegawai.keluarga.delete', ['pegawai' => $row['nip'], 'Rkeluarga' => $row['id']]) . "'>" . icons('trash') . "</a>";
                return $html;
            })
            ->rawColumns(['opsi', 'tempat_lahir', 'file'])
            ->addIndexColumn()->toJson();
    }
    public function datatable_orangtua(User $pegawai, DataTables $dataTables)
    {
        $keluarga = Keluarga::where('nip', $pegawai->nip)
            ->whereIn('status', ['ayah', 'ibu'])
            ->get();

        $Rkeluarga = KeluargaResource::collection($keluarga);

        return $dataTables->of($Rkeluarga)
        ->addColumn('nama', function ($row) {
            return $row['nama'];
        })
        ->addColumn('status', function ($row) {
            return $row['status'];
        })
        ->addColumn('tempat_lahir', function ($row) {
            return $row['tempat_lahir'] . " " . $row['tanggal_lahir'];
        })
        ->addColumn('file', function ($row) {
            if(is_null($row['file'])){
                    return "-";
            }
            return '<a class="badge badge-primary badge-outline" href="' . $row['file'] . '">Lihat Berkas</a>';
        })
        ->addColumn('opsi', function ($row) {

            $html = "<a class='me-2 edit' tooltip='Edit' href='" . route('pegawai.keluarga.edit', ['pegawai' => $row['nip'],"status"=>"orang-tua" , 'Rkeluarga' => $row['id']]) . "'>" . icons('pencil') . "</a>";
            $html .= "<a class='text-danger delete' tooltip='Hapus' href='" . route('pegawai.keluarga.delete', ['pegawai' => $row['nip'], 'Rkeluarga' => $row['id']]) . "'>" . icons('trash') . "</a>";
            return $html;
        })
        ->rawColumns(['opsi', 'tempat_lahir', 'file'])
        ->addIndexColumn()->toJson();
    }
    public function datatable_istri(User $pegawai, DataTables $dataTables)
    {
        $keluarga = Keluarga::where('nip', $pegawai->nip)
            ->whereIn('status', ['suami', 'istri'])
            ->get();

        $Rkeluarga = KeluargaResource::collection($keluarga);

        return $dataTables->of($Rkeluarga)
        ->addColumn('nama', function ($row) {
            return $row['nama'];
        })
        ->addColumn('status', function ($row) {
            return $row['status'];
        })
        ->addColumn('tempat_lahir', function ($row) {
            return $row['tempat_lahir'] . " " . $row['tanggal_lahir'];
        })
        ->addColumn('file', function ($row) {
            if(is_null($row['file'])){
                    return "-";
            }
            return '<a class="badge badge-primary badge-outline" href="' . $row['file'] . '">Lihat Berkas</a>';
        })
        ->addColumn('opsi', function ($row) {

            $html = "<a class='me-2 edit' tooltip='Edit' href='" . route('pegawai.keluarga.edit', ['pegawai' => $row['nip'], "status"=>"istri" ,'Rkeluarga' => $row['id']]) . "'>" . icons('pencil') . "</a>";
            $html .= "<a class='text-danger delete' tooltip='Hapus' href='" . route('pegawai.keluarga.delete', ['pegawai' => $row['nip'], 'Rkeluarga' => $row['id']]) . "'>" . icons('trash') . "</a>";
            return $html;
        })
        ->rawColumns(['opsi', 'tempat_lahir', 'file'])
        ->addIndexColumn()->toJson();
    }
    public function datatable_anak(User $pegawai, DataTables $dataTables)
    {
        $keluarga = Keluarga::where('nip', $pegawai->nip)
            ->where('status', 'anak')
            ->get();

        $Rkeluarga = KeluargaResource::collection($keluarga);

        return $dataTables->of($Rkeluarga)
        ->addColumn('nama', function ($row) {
            return $row['nama'];
        })
        ->addColumn('status', function ($row) {
            return $row['status'];
        })
        ->addColumn('tempat_lahir', function ($row) {
            return $row['tempat_lahir'] . " " . $row['tanggal_lahir'];
        })
        ->addColumn('file', function ($row) {
            if(is_null($row['file'])){
                    return "-";
            }
            return '<a class="badge badge-primary badge-outline" href="' . $row['file'] . '">Lihat Berkas</a>';
        })
        ->addColumn('opsi', function ($row) {

            $html = "<a class='me-2 edit' tooltip='Edit' href='" . route('pegawai.keluarga.edit', ['pegawai' => $row['nip'],"status"=>"anak" , 'Rkeluarga' => $row['id']]) . "'>" . icons('pencil') . "</a>";
            $html .= "<a class='text-danger delete' tooltip='Hapus' href='" . route('pegawai.keluarga.delete', ['pegawai' => $row['nip'], 'Rkeluarga' => $row['id']]) . "'>" . icons('trash') . "</a>";
            return $html;
        })
        ->rawColumns(['opsi', 'tempat_lahir', 'file'])
        ->addIndexColumn()->toJson();
    }
}
