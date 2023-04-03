<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\JabatanResource;
use App\Models\Pegawai\RiwayatJabatan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class PegawaiJabatanController extends Controller
{
    public function index(User $pegawai)
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $Rjabatan = RiwayatJabatan::with('tingkat')
            ->where('nip', $pegawai->nip)
            ->when($search, function ($qr, $search) {
                $qr->whereHas('tingkat', function ($qrt) use ($search) {
                    $qrt->where('nama', 'LIKE', "%$search%");
                });
            })
            ->orderByDesc('tanggal_tmt')
            ->paginate($limit);

        $Rjabatan->appends(request()->all());

        $Rjabatan = JabatanResource::collection($Rjabatan);
        return inertia('Pegawai/Jabatan/index', compact('pegawai', 'Rjabatan'));
    }

    public function add(User $pegawai)
    {
        $Rjabatan = null;
        $for = 0;
        // return inertia('Pegawai/Jabatan/Add', compact('pegawai', 'Rjabatan'));
        $data['data'] = $Rjabatan;
        $data['view'] = view('pages.pegawai.pegawai.datariwayat.jabatan.add',compact('pegawai', 'Rjabatan','for'))->render();
        return response()->json($data);

        // return view('pages.pegawai.pegawai.datariwayat.jabatan.add',compact('pegawai', 'Rjabatan'));
    }

    public function edit(User $pegawai, RiwayatJabatan $Rjabatan)
    {
   
     
        $for = 1;
        // return inertia('Pegawai/Jabatan/Add', compact('pegawai', 'Rjabatan'));
        $data['data'] = $Rjabatan;
        $data['view'] = view('pages.pegawai.pegawai.datariwayat.jabatan.add',compact('pegawai', 'Rjabatan','for'))->render();
        return response()->json($data);
    }

    public function delete(User $pegawai, RiwayatJabatan $Rjabatan)
    {
        if ($Rjabatan->file) {
            Storage::delete($Rjabatan->file);
        }
        $cr = $Rjabatan->delete();
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

    public function akhir(User $pegawai, RiwayatJabatan $Rjabatan)
    {
        RiwayatJabatan::where('nip', $pegawai->nip)->update(['is_akhir' => 0]);
        $cr = $Rjabatan->update(['is_akhir' => 1]);
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
            'no_sk' => 'required|unique:riwayat_jabatan',
            'kode_skpd' => 'required',
            'kode_tingkat' => 'required',
            'jenis_jabatan' => 'required',
            'no_sk' => 'nullable',
            'tanggal_sk' => 'nullable',
            'tanggal_tmt' => 'nullable',
            'sebagai' => 'nullable',
            'is_akhir' => 'nullable',
        ];

        if (request()->file('file')) {
            $rules['file'] = 'mimes:pdf|max:2048';
        }

        $data = request()->validate($rules);
        $data['tanggal_sk'] = date("Y-m-d",strtotime(str_replace("/","-", $data["tanggal_sk"])));
        $data['tanggal_tmt'] =  date("Y-m-d",strtotime(str_replace("/","-", $data["tanggal_tmt"])));
        

        if (request('is_akhir') == 1) {
            $data['sebagai'] = "defenitif";
            RiwayatJabatan::where('nip', $pegawai->nip)->update(['is_akhir' => 0]);
        }

        $id = request('id');
        if ($id) {
            if (request()->file('file')) {
                $file = RiwayatJabatan::where('id', $id)->where('nip', $pegawai->nip)->value('file');
                if ($file) {
                    Storage::delete($file);
                }
            }
        }

        if (request()->file('file')) {
            $data['file'] = request()->file('file')->storeAs('data_pegawai/'.$pegawai->nip.'/riwayat_jabatan', $pegawai->nip . "-jabatan-" . date("YmdHis") . ".pdf");
        }

        $cr = RiwayatJabatan::updateOrCreate(
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
    public function datatable(User $pegawai, DataTables $dataTables)
    {
        $Rjabatan = RiwayatJabatan::with('tingkat')
        ->where('nip', $pegawai->nip)->get();
        $Rjabatan = JabatanResource::collection($Rjabatan);
        
        // dd($Rjabatan[0]->tingkat?->eselon?->nama);
        return $dataTables->of($Rjabatan)
            ->addColumn('jenis_jabatan', function ($row) {
                if($row->jenis_jabatan){
                    return (($row->is_akhir == 1)?'<i class="bi bi-bookmark-star-fill text-danger fs-4"></i>' : '').jenis_jabatan($row->jenis_jabatan);
                }
                return "-";
            })
            ->addColumn('nama_jabatan', function ($row) {
                
                return $row->tingkat?->nama ?? "-";

            })
            ->addColumn('tanggal_tmt', function ($row) {
                
                return tanggal_indo($row->tanggal_tmt);

            })
            ->addColumn('tanggal_sk', function ($row) {
                return tanggal_indo($row['tanggal_sk']);
            })
            ->addColumn('no_sk', function ($row) {
                return $row->no_sk ?? "-";
            })
            ->addColumn('level', function ($row) {
                
                return $row->tingkat?->eselon?->nama ?? "-";

            })
            ->addColumn('divisi', function ($row) {
                
                return $row->skpd?->nama ?? "-";
                
            })
            ->addColumn('file', function ($row) {

                return '<a class="badge badge-primary badge-outline" href="' . url('/'.$row['file']) . '">Lihat Berkas</a>';
            })
            ->addColumn('opsi', function ($row) {

                $html = "<a class='me-2 edit' tooltip='edit' href='" . route('pegawai.jabatan.edit', ['pegawai' => $row['nip'], 'Rjabatan' => $row['id']]) . "'>" . icons('pencil') . "</a>";
                $html .= "<a class='text-danger delete' tooltip='Hapus' href='" . route('pegawai.jabatan.delete', ['pegawai' => $row['nip'], 'Rjabatan' => $row['id']]) . "'>" . icons('trash') . "</a>";
                return $html;
            })
            ->rawColumns(['opsi', 'jenis_jabatan', 'nama_jabatan', 'level', 'divisi', 'file'])
            ->addIndexColumn()->toJson();
    }
}
