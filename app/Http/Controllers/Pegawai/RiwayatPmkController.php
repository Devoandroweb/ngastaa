<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\RiwayatPmkResource;
use App\Models\Pegawai\RiwayatPmk;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class RiwayatPmkController extends Controller
{
    public function index(User $pegawai)
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $Rpmk = RiwayatPmk::where('nip', $pegawai->nip)
            ->orderByDesc('tanggal_sk')
            ->paginate($limit);

        $Rpmk->appends(request()->all());
        $Rpmk = RiwayatPmkResource::collection($Rpmk);
        return inertia('Pegawai/Pmk/index', compact('pegawai', 'Rpmk'));
    }

    public function add(User $pegawai)
    {
        $Rpmk = null;
        // return inertia('Pegawai/Pmk/Add', compact('pegawai', 'Rpmk'));
        
        $for = 0;
        $view = view('pages.pegawai.pegawai.datalainnya.pengalamankerja.add',compact('pegawai', 'Rpmk', 'for'))->render();
        return response()->json(["view"=>$view]);
    }

    public function edit(User $pegawai, RiwayatPmk $Rpmk)
    {
        // return inertia('Pegawai/Pmk/Add', compact('pegawai', 'Rpmk'));
    
        $for = 1;
        $view = view('pages.pegawai.pegawai.datalainnya.pengalamankerja.add',compact('pegawai', 'Rpmk', 'for'))->render();
        return response()->json(["view"=>$view]);
    }

    public function delete(User $pegawai, RiwayatPmk $Rpmk)
    {
        $cr = $Rpmk->delete();
        if ($cr) {
            return redirect(route('pegawai.pmk.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('pegawai.pmk.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store(User $pegawai)
    {
        $rules = [
            'jenis_pmk' => 'required',
            'instansi' => 'required',
            'tanggal_awal' => 'required',
            'tanggal_akhir' => 'required',
            // 'nomor_sk' => 'required',
            // 'tanggal_sk' => 'required',
            'masa_kerja_bulan' => 'required',
            'masa_kerja_tahun' => 'required',
            'nomor_bkn' => 'nullable',
            'tanggal_bkn' => 'nullable',
        ];

        if (request()->file('file')) {
            $rules['file'] = 'mimes:pdf|max:2048';
        }

        $data = request()->validate($rules);
        
        $data['tanggal_awal'] = date('Y-m-d', strtotime(str_replace("/","-", $data["tanggal_awal"])));
        $data['tanggal_akhir'] = date('Y-m-d', strtotime(str_replace("/","-", $data["tanggal_akhir"])));

        $id = request('id');
        if ($id) {
            if (request()->file('file')) {
                $file = RiwayatPmk::where('id', $id)->where('nip', $pegawai->nip)->value('file');
                if ($file) {
                    @unlink($file);
                }
            }
        }

        if (request()->file('file')) {
            // $data['file'] = request()->file('file')->storeAs($pegawai->nip, $pegawai->nip . "-pmk-" . request('jenis_pmk') . date("His") . ".pdf");
            $dir = 'data_pegawai/'.$pegawai->nip.'/pengalaman_kerja';
            $data['file'] = $dir.'/'.uploadFile($dir,request()->file('file'));
        }

        $cr = RiwayatPmk::updateOrCreate(
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
        $Rpmk = RiwayatPmk::where('nip', $pegawai)
            ->orderByDesc('tanggal_sk')
            ->get();
        $Rpmk = RiwayatPmkResource::collection($Rpmk);
        return $dataTables->of($Rpmk)
        ->addColumn('instansi', function ($row) {
            return  $row['instansi'];
        })
        ->addColumn('nomor_sk', function ($row) {
            return  $row['nomor_sk'];
        })
        ->addColumn('tanggal_sk', function ($row) {
            return tanggal_indo($row['tanggal_sk']) ;
        })
        ->addColumn('masa_kerja', function ($row) {
            return "Tahun ".$row['masa_kerja_tahun']." Bulan ".$row['masa_kerja_bulan'] ;
        })
        ->addColumn('file', function ($row) {
            if(is_null($row['file'])){
                return "-";
            }
            return '<a class="badge badge-primary badge-outline" href="' . $row['file'] . '">Lihat Berkas</a>';
        })
        ->addColumn('opsi', function ($row) {

            $html = "<a class='me-2 edit' tooltip='Edit' href='" . route('pegawai.pmk.edit', ['pegawai' => $row['nip'], 'Rpmk' => $row['id']]) . "'>" . icons('pencil') . "</a>";
            $html .= "<a class='text-danger delete' tooltip='Hapus' href='" . route('pegawai.pmk.delete', ['pegawai' => $row['nip'], 'Rpmk' => $row['id']]) . "'>" . icons('trash') . "</a>";
            return $html;
        })
        ->rawColumns(['opsi', 'tempat_lahir', 'file'])
        ->addIndexColumn()->toJson();
    }
}
