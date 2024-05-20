<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Master\JamKerjaResource;
use App\Http\Resources\Select\SelectResource;
use App\Models\HariJamKerja;
use App\Models\MJamKerja;
use App\Repositories\JamKerja\JamKerjaRepository;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class JamKerjaController extends Controller
{
    protected $jamKerjaRepository;
    function __construct(JamKerjaRepository $jamKerjaRepository){
        $this->jamKerjaRepository = $jamKerjaRepository;
    }
    public function index()
    {
        return view('pages/masterdata/datapresensi/jam_kerja/index');
    }

    public function json()
    {
        $jamKerja = MJamKerja::orderBy('nama')->get();
        SelectResource::withoutWrapping();
        $jamKerja = SelectResource::collection($jamKerja);

        return response()->json($jamKerja);
    }
    public function json_all()
    {
        $jamKerja = MJamKerja::all();
        return response()->json($jamKerja);
    }

    public function add()
    {
        $jamKerja = null;
        $for = 0;
        $hari = [];
        return view('pages.masterdata.datapresensi.jam_kerja.add', compact('jamKerja','for','hari'));
    }

    public function edit(MJamKerja $jamKerja)
    {
        $for = 1;
        $jamKerja->load('hariJamKerja');
        return view('pages.masterdata.datapresensi.jam_kerja.add', compact('jamKerja','for'));
    }

    public function delete(MJamKerja $jamKerja)
    {
        HariJamKerja::where('kode_jam_kerja',$jamKerja->kode)->delete();
        $cr = $jamKerja->delete();
        if ($cr) {
            Artisan::call("init:master-jam-kerja");
            return redirect(route('master.jam_kerja.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('master.jam_kerja.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store()
    {
        $rules = [
            'kode' => 'required',
            'nama' => 'required',
        ];

        if (!request('id')) {
            $rules['kode'] = 'required|unique:m_jam_kerja';
        }
        $data = request()->validate($rules);
        try {
            DB::transaction(function()use($data){
                // dd(request()->all());


                for ($i=1; $i <= 7; $i++) {
                    $filler = request('filler_'.$i);
                    if($filler == 2){
                        $dataHariJamKerja = [
                            'kode_jam_kerja' => $data['kode'],
                            'hari' => $i,
                            'jam_buka_datang' => request('jam_buka_datang')[$i-1],
                            'jam_tepat_datang' => request('jam_tepat_datang')[$i-1],
                            'jam_tutup_datang' => request('jam_tutup_datang')[$i-1],
                            'toleransi_datang' => request('toleransi_datang')[$i-1],
                            'jam_buka_istirahat' => request('jam_buka_istirahat')[$i-1],
                            'jam_tepat_istirahat' => request('jam_tepat_istirahat')[$i-1],
                            'jam_tutup_istirahat' => request('jam_tutup_istirahat')[$i-1],
                            'toleransi_istirahat' => request('toleransi_istirahat')[$i-1],
                            'jam_buka_pulang' => request('jam_buka_pulang')[$i-1],
                            'jam_tepat_pulang' => request('jam_tepat_pulang')[$i-1],
                            'jam_tutup_pulang' => request('jam_tutup_pulang')[$i-1],
                            'toleransi_pulang' => request('toleransi_pulang')[$i-1],
                            'tipe' => request('filler_'.$i)
                        ];
                    }elseif($filler == 1){
                        if(request('filler_'.request('copy-other-day-'.$i)) == 0){
                            HariJamKerja::where([
                                "kode_jam_kerja" => $data['kode'],
                                "hari" => $i
                            ])->delete();
                            continue;
                        }else{
                            $dataHariJamKerja = [
                                'kode_jam_kerja'=>$data['kode'],
                                'hari' => $i,
                                'tipe' => $filler,
                                'parent' => request('copy-other-day-'.$i)
                            ];
                        }
                    }
                    if(in_array($filler,[1,2])){
                        // dd($dataHariJamKerja);
                        HariJamKerja::updateOrCreate(
                            [
                                'kode_jam_kerja'=>$data['kode'],
                                'hari' => $i
                            ],
                            $dataHariJamKerja
                        );
                    }
                }
                // dd("okde");
                MJamKerja::updateOrCreate(['id' => request('id')],['kode'=>$data['kode'],'nama'=>$data['nama']]);
            });
            DB::commit();
            Artisan::call("init:master-jam-kerja");
            return redirect(route('master.jam_kerja.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil!"
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect(route('master.jam_kerja.index'))->with([
                'type' => 'error',
                'messages' => $th->getMessage()
            ]);
        }



    }
    public function datatable(DataTables $dataTables)
    {
        $rawColumns = ['opsi'];
        $model = MJamKerja::query();
        $dt = $dataTables->eloquent($model);
        $dt->addColumn('hari', function ($row) {
            return $row->toleransi_istirahat . " m";
        });
        for ($i=1; $i <= 7 ; $i++) {
            $hari = strtolower(hari($i));
            array_push($rawColumns,$hari);
            $dt->addColumn($hari, function ($row) use ($i,$hari){
                $hariJamKerja = $this->jamKerjaRepository->searchHariJamKerja($row->kode,$i);
                if($hariJamKerja){
                    return '<a href="#" class="text-primary detail-jam" tooltip="Klik untuk Melihat detail Jam" data-hari="'.$hari.'" data-tipe="'.$hariJamKerja->tipe.'" data-parent="'.strtolower(hari($hariJamKerja->parent)).'"><i class="far fa-eye"></i> Lihat</a>';
                }
                return "-";
            });
            $dt->addColumn($hari."_json", function ($row) use ($i){
                // return json_encode($this->jamKerjaRepository->searchHariJamKerja($row->kode,$i));
                return $this->jamKerjaRepository->searchHariJamKerja($row->kode,$i);
            });
        }

        $dt->addColumn('opsi', function ($row) {
            $html = "";
            if(getPermission('masterDataJamKerja','U') || role('owner') || role('admin')){
                $html .= "<a class='me-2 edit' tooltip='Edit' href='" . route('master.jam_kerja.edit', $row->id) . "'>" . icons('pencil') . "</a>";
            }
            if(getPermission('masterDataJamKerja','D') || role('owner') || role('admin')){
                $html .= "<a class='delete text-danger' tooltip='Hapus' href='" . route('master.jam_kerja.delete', $row->id) . "'>" . icons('trash') . "</a>";
            }
            if($html == ""){
                return "-";
            }
            return $html;
        });
        return $dt->rawColumns($rawColumns)
        ->addIndexColumn()
        ->toJson();
    }
}
