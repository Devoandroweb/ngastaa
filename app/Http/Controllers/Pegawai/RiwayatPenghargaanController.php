<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\RiwayatPenghargaanResource;
use App\Models\Pegawai\RiwayatPenghargaan;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class RiwayatPenghargaanController extends Controller
{
    public function index(User $pegawai)
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $Rpenghargaan = RiwayatPenghargaan::where('nip', $pegawai->nip)
            ->orderByDesc('tanggal_sk')
            ->paginate($limit);

        $Rpenghargaan->appends(request()->all());
        $Rpenghargaan = RiwayatPenghargaanResource::collection($Rpenghargaan);
        return inertia('Pegawai/Penghargaan/index', compact('pegawai', 'Rpenghargaan'));
    }

    public function add(User $pegawai)
    {
        // return view('pages.pegawai.pegawai.datariwayat.Penghargaan.edit',compact('pegawai', 'Rpenghargaan'));
        // return inertia('Pegawai/Penghargaan/Add', compact('pegawai', 'Rpenghargaan'));
        $Rpenghargaan = null;
        $for = 0;
        $data['data'] = $Rpenghargaan;
        $data['view'] = view('pages.pegawai.pegawai.datariwayat.penghargaan.add',compact('pegawai', 'Rpenghargaan', 'for'))->render();
        return response()->json($data);
    }

    public function edit(User $pegawai, RiwayatPenghargaan $Rpenghargaan)
    {
        // return view('pages.pegawai.pegawai.datariwayat.Penghargaan.edit',compact('pegawai', 'Rpenghargaan'));
        $for = 1;
        $data['data'] = $Rpenghargaan;
        $data['view'] = view('pages.pegawai.pegawai.datariwayat.penghargaan.add',compact('pegawai', 'Rpenghargaan', 'for'))->render();
        return response()->json($data);
        // return inertia('Pegawai/Penghargaan/Add', compact('pegawai', 'Rpenghargaan'));
    }

    public function delete(User $pegawai, RiwayatPenghargaan $Rpenghargaan)
    {
        $cr = $Rpenghargaan->delete();
        if ($cr) {
            return redirect(route('pegawai.penghargaan.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('pegawai.penghargaan.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store(User $pegawai)
    {
        $rules = [
            'kode_penghargaan' => 'required',
            'oleh' => 'nullable',
            'nomor_sk' => 'required',
            'tanggal_sk' => 'nullable',
        ];

        if (request()->file('file')) {
            $rules['file'] = 'mimes:pdf|max:2048';
        }

        $data = request()->validate($rules);
        $data['tanggal_sk'] =  date("Y-m-d",strtotime($data["tanggal_sk"]));

        $id = request('id');
        if ($id) {
            if (request()->file('file')) {
                $file = RiwayatPenghargaan::where('id', $id)->where('nip', $pegawai->nip)->value('file');
                if ($file) {
                    Storage::delete($file);
                }
            }
        }

        if (request()->file('file')) {
            $data['file'] = request()->file('file')->storeAs($pegawai->nip, $pegawai->nip . "-penghargaan-" . request('nomor_sk') . ".pdf");
        }

        $cr = RiwayatPenghargaan::updateOrCreate(
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
    public function datatable($pegawai, DataTables $dataTables)
    {
        $Rpenghargaan = RiwayatPenghargaan::where('nip', $pegawai)
            ->orderByDesc('tanggal_sk')
            ->get();
        $Rpenghargaan = RiwayatPenghargaanResource::collection($Rpenghargaan);
        return $dataTables->of($Rpenghargaan)
        
        ->addColumn('penghargaan', function ($row) {
            return  $row['penghargaan']['nama'] ;
        })
        ->addColumn('oleh', function ($row) {
            return  $row['oleh'] ;
        })
        ->addColumn('nomor_sk', function ($row) {
            return  $row['nomor_sk'] ;
        })
        ->addColumn('tanggal_sk', function ($row) {
            return tanggal_indo($row['tanggal_sk']) ;
        })
        ->addColumn('file', function ($row) {
            return '<a class="badge badge-primary badge-outline" href="' . $row['file'] . '">Lihat Berkas</a>';
        })
        ->addColumn('opsi', function ($row) {

            $html = "<a class='me-2 edit' tooltip='Edit' href='" . route('pegawai.penghargaan.edit', ['pegawai' => $row['nip'], 'Rpenghargaan' => $row['id']]) . "'>" . icons('pencil') . "</a>";
            $html .= "<a class='text-danger delete' tooltip='Hapus' href='" . route('pegawai.penghargaan.delete', ['pegawai' => $row['nip'], 'Rpenghargaan' => $row['id']]) . "'>" . icons('trash') . "</a>";
            return $html;
        })
        ->rawColumns(['opsi', 'file'])
        ->addIndexColumn()->toJson();
    }
}
