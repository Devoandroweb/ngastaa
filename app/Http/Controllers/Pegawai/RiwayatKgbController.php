<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\RiwayatKgbResource;
use App\Models\Pegawai\RiwayatKgb;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class RiwayatKgbController extends Controller
{
    public function index(User $pegawai)
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $nOwner = !role('owner');

        $Rkgb = RiwayatKgb::where('nip', $pegawai->nip)
            ->orderByDesc('tanggal_surat')
            ->when($nOwner, function ($qr) {
                $qr->where('is_private', 0);
            })
            ->paginate($limit);

        $Rkgb->appends(request()->all());
        $Rkgb = RiwayatKgbResource::collection($Rkgb);
        return inertia('Pegawai/Kgb/index', compact('pegawai', 'Rkgb'));
    }

    public function add(User $pegawai)
    {
        $Rkgb = null;
        $for = 0;
        $data['data'] = $Rkgb;
        $data['view'] =  view('pages.pegawai.pegawai.datariwayat.gajipokok.add',compact('pegawai', 'Rkgb', 'for'))->render();
        return response()->json($data);
    }

    public function edit(User $pegawai, RiwayatKgb $Rkgb)
    {
        
        $for = 1;
        // return inertia('Pegawai/Kgb/Add', compact('pegawai', 'Rkgb'));
        // return view('pages.pegawai.pegawai.datariwayat.GajiPokok.edit',compact('pegawai', 'Rkgb'));
        $data['data'] = $Rkgb;
        $data['view'] =  view('pages.pegawai.pegawai.datariwayat.gajipokok.add',compact('pegawai', 'Rkgb', 'for'))->render();
        return response()->json($data);

    }

    public function delete(User $pegawai, RiwayatKgb $Rkgb)
    {
        if ($Rkgb->file) {
            Storage::delete($Rkgb->file);
        }
        $cr = $Rkgb->delete();
        if ($cr) {
            return redirect(route('pegawai.kgb.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('pegawai.kgb.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function akhir(User $pegawai, RiwayatKgb $Rkgb)
    {
        RiwayatKgb::where('nip', $pegawai->nip)->update(['is_akhir' => 0]);
        $cr = $Rkgb->update(['is_akhir' => 1]);
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
            'nomor_surat' => 'required',
            'tanggal_surat' => 'required',
            'tanggal_tmt' => 'required',
            'is_akhir' => 'required',
            'is_private' => 'nullable',
            'tipe_gaji' => 'nullable',
            'kode_umk' => 'nullable',
            'gaji_pokok' => 'nullable',
            'masa_kerja_tahun' => 'nullable',
            'masa_kerja_bulan' => 'nullable',
        ];

        if (request()->file('file')) {
            $rules['file'] = 'mimes:pdf|max:2048';
        }

        if (request('is_akhir') == 1) {
            RiwayatKgb::where('nip', $pegawai->nip)->update(['is_akhir' => 0]);
        }

        $data = request()->validate($rules);
        $data['tanggal_surat'] = date("Y-m-d",strtotime(str_replace("/","-", $data["tanggal_surat"])));
        $data['tanggal_tmt'] =  date("Y-m-d",strtotime(str_replace("/","-", $data["tanggal_tmt"])));
        if (request('gaji_pokok')) {
            $data['gaji_pokok'] = number_to_sql($data['gaji_pokok']);
        }

        $id = request('id');
        if ($id) {
            if (request()->file('file')) {
                $file = RiwayatKgb::where('id', $id)->where('nip', $pegawai->nip)->value('file');
                if ($file) {
                    Storage::delete($file);
                }
            }
        }

        if (request()->file('file')) {
            // $data['file'] = request()->file('file')->storeAs($pegawai->nip, $pegawai->nip . "-kgb-" . request('nomor_surat') . ".pdf");
            $dir = 'data_pegawai/'.$pegawai->nip.'/gaji_pokok';
            $data['file'] = $dir.'/'.uploadFile($dir,request()->file('file'));
        }

        $cr = RiwayatKgb::updateOrCreate(
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

        $nOwner = !role('owner');

        $Rkgb = RiwayatKgb::where('nip', $pegawai)
            ->orderByDesc('tanggal_surat')
            ->when($nOwner, function ($qr) {
                $qr->where('is_private', 0);
            })->get();
        // $Rkgb = RiwayatKgbResource::collection($Rkgb);
        return $dataTables->of($Rkgb)
        ->addColumn('nomor_surat', function ($row) {
            return  $row['nomor_surat'] ;
        })
        ->addColumn('tanggal_tmt', function ($row) {
            return tanggal_indo($row['tanggal_tmt']) ;
        })
        ->addColumn('gaji_pokok', function ($row) {
            return  number_indo($row['gaji_pokok']) ;
        })
        ->addColumn('masa_kerja', function ($row) {
            // return $row['masa_kerja'] ;
            return $row['masa_kerja_tahun'] ." Tahun - " .$row['masa_kerja_bulan'] ." Bulan";
        })
        ->addColumn('file', function ($row) {
            if(is_null($row['file'])){
                    return "-";
            }
            return '<a class="badge badge-primary badge-outline" href="' . $row['file'] . '">Lihat Berkas</a>';
        })
        ->addColumn('is_private', function ($row) {
            return isPrivateBagde($row['is_private']);
        })
        ->addColumn('opsi', function ($row) {
            $html = "<a class='me-2 edit' tooltip='Edit' href='" . route('pegawai.kgb.edit', ['pegawai' => $row['nip'], 'Rkgb' => $row['id']]) . "'>" . icons('pencil') . "</a>";
            $html .= "<a class='text-danger delete' tooltip='Hapus' href='" . route('pegawai.kgb.delete', ['pegawai' => $row['nip'], 'Rkgb' => $row['id']]) . "'>" . icons('trash') . "</a>";
            return $html;
        })
        ->rawColumns(['opsi', 'file','is_private'])
        ->addIndexColumn()->toJson();
    }
}
