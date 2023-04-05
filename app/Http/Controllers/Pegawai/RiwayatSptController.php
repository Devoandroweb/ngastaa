<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\RiwayatSptResource;
use App\Models\Pegawai\RiwayatSpt;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class RiwayatSptController extends Controller
{
    public function index(User $pegawai)
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $Rspt = RiwayatSpt::where('nip', $pegawai->nip)
            ->orderByDesc('tahun')
            ->paginate($limit);

        $Rspt->appends(request()->all());

        $Rspt = RiwayatSptResource::collection($Rspt);
        return inertia('Pegawai/Spt/index', compact('pegawai', 'Rspt'));
    }

    public function add(User $pegawai)
    {
        $Rspt = null;
        // return inertia('Pegawai/Spt/Add', compact('pegawai', 'Rspt'));
        $for = 0;
        $view = view('pages.pegawai.pegawai.datalainnya.spttahunan.add',compact('pegawai', 'Rspt', 'for'))->render();
        return response()->json(["view"=>$view]);
    
    }

    public function edit(User $pegawai, RiwayatSpt $Rspt)
    {
        // return inertia('Pegawai/Spt/Add', compact('pegawai', 'Rspt'));

        $for = 1;
        $view = view('pages.pegawai.pegawai.datalainnya.spttahunan.add',compact('pegawai', 'Rspt', 'for'))->render();
        return response()->json(["view"=>$view]);
    }

    public function delete(User $pegawai, RiwayatSpt $Rspt)
    {
        $cr = $Rspt->delete();
        if ($cr) {
            return redirect(route('pegawai.spt.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('pegawai.spt.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store(User $pegawai)
    {
        $rules = [
            'jenis_spt' => 'required',
            'status_spt' => 'required',
            'nominal' => 'nullable',
            'tanggal_penyampaian' => 'nullable',
            'nomor_tanda_terima_elektronik' => 'required',
        ];

        if (request()->file('file')) {
            $rules['file'] = 'mimes:pdf|max:2048';
        }

        $data = request()->validate($rules);
        $data['tahun'] = request('tahun') ?? date('Y');
        $data['tanggal_penyampaian'] = date('Y-m-d', strtotime(str_replace("/","-", $data["tanggal_penyampaian"])));


        if (request('nominal')) {
            $data['nominal'] = number_to_sql($data['nominal']);
        }

        $id = request('id');
        if ($id) {
            if (request()->file('file')) {
                $file = RiwayatSpt::where('id', $id)->where('nip', $pegawai->nip)->value('file');
                if ($file) {
                    @unlink($file);
                }
            }
        }

        if (request()->file('file')) {
            // $data['file'] = request()->file('file')->storeAs($pegawai->nip, $pegawai->nip . "-spt-" . request('tahun') . ".pdf");
            $dir = 'data_pegawai/'.$pegawai->nip.'/spt';
            $data['file'] = $dir.'/'.uploadFile($dir,request()->file('file'));
        }

        $cr = RiwayatSpt::updateOrCreate(
            [
                'id' => $id,
                'nip' => $pegawai->nip,
            ],
            $data
        );

        if ($cr) {
            return redirect(route('pegawai.spt.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, diperbaharui!"
            ]);
        } else {
            return redirect(route('pegawai.spt.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, diperbaharui!"
            ]);
        }
    }
    public function datatable($pegawai,DataTables $dataTables){
        $Rspt = RiwayatSpt::where('nip', $pegawai)
            ->orderByDesc('tahun')->get();
        $Rspt = RiwayatSptResource::collection($Rspt);
        return $dataTables->of($Rspt)

        ->addColumn('tahun', function ($row) {
            return  $row['tahun'] ;
        })
        ->addColumn('jenis_spt', function ($row) {
            return  $row['jenis_spt'];
        })
        ->addColumn('status_spt', function ($row) {
            return  $row['status_spt'];
        })
        ->addColumn('nominal', function ($row) {
            return  number_indo($row['nominal']);
        })
        ->addColumn('tanggal_penyampaian', function ($row) {
            return tanggal_indo($row['tanggal_penyampaian']) ;
        })
        ->addColumn('nomor_tanda_terima_elektronik', function ($row) {
            return  $row['nomor_tanda_terima_elektronik'];
        })
        ->addColumn('file', function ($row) {
            if(is_null($row['file'])){
                    return "-";
            }
            return '<a class="badge badge-primary badge-outline" href="' . $row['file'] . '">Lihat Berkas</a>';
        })
        ->addColumn('opsi', function ($row) {

            $html = "<a class='me-2 edit' tooltip='Edit' href='" . route('pegawai.spt.edit', ['pegawai' => $row['nip'], 'Rspt' => $row['id']]) . "'>" . icons('pencil') . "</a>";
            $html .= "<a class='text-danger delete' tooltip='Hapus' href='" . route('pegawai.spt.delete', ['pegawai' => $row['nip'], 'Rspt' => $row['id']]) . "'>" . icons('trash') . "</a>";
            return $html;
        })
        ->rawColumns(['opsi', 'tempat_lahir', 'file'])
        ->addIndexColumn()->toJson();
    }
}
