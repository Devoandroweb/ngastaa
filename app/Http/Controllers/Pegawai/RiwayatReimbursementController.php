<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pengajuan\ReimbursementPengajuanResource;
use App\Models\Pegawai\DataPengajuanReimbursement;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class RiwayatReimbursementController extends Controller
{
    public function index(User $pegawai)
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $Rreimbursement = DataPengajuanReimbursement::where('nip', $pegawai->nip)
            ->orderByDesc('tanggal_surat')
            ->paginate($limit);

        $Rreimbursement->appends(request()->all());
        $Rreimbursement = ReimbursementPengajuanResource::collection($Rreimbursement);
        return inertia('Pegawai/Reimbursement/index', compact('pegawai', 'Rreimbursement'));
    }

    public function add(User $pegawai)
    {
        $Rreimbursement = null;
        // return view('pages.pegawai.pegawai.datariwayat.reimbursement.add',compact('pegawai', 'Rreimbursement'));
        // return inertia('Pegawai/Reimbursement/Add', compact('pegawai', 'Rreimbursement'));
        $for = 0;
        $data['data'] = $Rreimbursement;
        $data['view'] = view('pages.pegawai.pegawai.datariwayat.reimbursement.add',compact('pegawai', 'Rreimbursement','for'))->render();
        return response()->json($data);
    }

    public function edit(User $pegawai, DataPengajuanReimbursement $Rreimbursement)
    {

        // return view('pages.pegawai.pegawai.datariwayat.Reimbursement.edit',compact('pegawai', 'Rreimbursement'));
        // return inertia('Pegawai/Reimbursement/Add', compact('pegawai', 'Rreimbursement'));
        $for = 1;
        $data['data'] = $Rreimbursement;
        $data['view'] = view('pages.pegawai.pegawai.datariwayat.reimbursement.add',compact('pegawai', 'Rreimbursement','for'))->render();
        return response()->json($data);
    }

    public function delete(User $pegawai, DataPengajuanReimbursement $Rreimbursement)
    {
        tambah_log($pegawai->nip, "App\Pegawai\DataPengajuanReimbursement", $Rreimbursement->id, 'dihapus');
        $cr = $Rreimbursement->delete();
        if ($cr) {
            return redirect(route('pegawai.reimbursement.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('pegawai.reimbursement.index', $pegawai->nip))->with([
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
            'nilai' => 'required',
            'kode_reimbursement' => 'required',
            'keterangan' => 'nullable',
        ];

        if (request()->file('file')) {
            $rules['file'] = 'mimes:pdf|max:2048';
        }

        $data = request()->validate($rules);
        $data['tanggal_surat'] = normalDateSystem(request("tanggal_surat"));
        $data['nilai'] = number_to_sql($data['nilai']);

        $id = request('id');
        if ($id) {
            if (request()->file('file')) {
                $file = DataPengajuanReimbursement::where('id', $id)->where('nip', $pegawai->nip)->value('file');
                if ($file) {
                    @unlink($file);
                }
            }
            tambah_log($pegawai->nip, "App\Pegawai\DataPengajuanReimbursement", $id, 'diubah');
        }

        // upload file
        if (request()->file('file')) {
            $file = DataPengajuanReimbursement::where('id', $id)->where('nip', $pegawai->nip)->value('file');
            $dir = 'data_pegawai/'.$pegawai->nip.'/reimbursement';
            if ($file) {
                @unlink($dir."/".$file);
            }
            $data['file'] = $dir.'/'.uploadFile($dir,request()->file('file'));
        }

        $cr = DataPengajuanReimbursement::updateOrCreate(
            [
                'id' => $id,
                'nip' => $pegawai->nip,
            ],
            $data
        );

        if (!$id) {
            tambah_log($pegawai->nip, "App\Pegawai\DataPengajuanReimbursement", $cr->id, 'ditambahkan');
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

        $Rreimbursement = DataPengajuanReimbursement::where('nip', $pegawai)
            ->orderByDesc('tanggal_surat')
            ->get();

        $Rreimbursement = ReimbursementPengajuanResource::collection($Rreimbursement);
        return $dataTables->of($Rreimbursement)
            ->addColumn('nama', function ($row) {
                return  optional($row['reimbursement'])['nama'];
            })
            ->addColumn('nilai', function ($row) {
                return  number_indo($row['nilai']) ;
            })
            ->addColumn('nomor_surat', function ($row) {
                return  $row['nomor_surat'] ;
            })
            ->addColumn('tanggal_surat', function ($row) {
                return tanggal_indo($row['tanggal_surat']) ;
            })
            ->addColumn('keterangan', function ($row) {
                return  $row['keterangan'] ;
            })
            ->addColumn('file', function ($row) {
                if(is_null($row['file'])){
                        return "-";
                }
                return '<a class="badge badge-primary badge-outline" href="' . $row['file'] . '">Lihat Berkas</a>';
            })
            ->addColumn('opsi', function ($row) {

                $html = "<a class='me-2 edit' tooltip='Edit' href='" . route('pegawai.reimbursement.edit', ['pegawai' => $row['nip'], 'Rreimbursement' => $row['id']]) . "'>" . icons('pencil') . "</a>";
                $html .= "<a class='text-danger delete' tooltip='Hapus' href='" . route('pegawai.reimbursement.delete', ['pegawai' => $row['nip'], 'Rreimbursement' => $row['id']]) . "'>" . icons('trash') . "</a>";
                return $html;
            })
            ->rawColumns(['opsi', 'file'])
            ->addIndexColumn()->toJson();
    }
}
