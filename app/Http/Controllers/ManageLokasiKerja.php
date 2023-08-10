<?php

namespace App\Http\Controllers;

use App\Models\MapLokasiKerja;
use App\Models\Master\Lokasi;
use App\Models\Master\LokasiDetail;
use App\Models\Master\Skpd;
use App\Models\User;
use App\Repositories\LokasiKerja\LokasiKerjaRepository;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ManageLokasiKerja extends Controller
{
    protected $lokasiKerjaRepository;
    protected $skpd;
    protected $lokasiKerja;
    function __construct(
        LokasiKerjaRepository $lokasiKerjaRepository,
        Skpd $skpd,
        Lokasi $lokasiKerja,
    ){
        $this->lokasiKerjaRepository = $lokasiKerjaRepository;
        $this->skpd = $skpd;
        $this->lokasiKerja = $lokasiKerja;
    }
    function index(){
        $skpd = $this->skpd->get();
        return view('pages.manage_lokasi_kerja.index',compact('skpd'));
    }
    function store() {
        $kodeLokasi = request('kode_lokasi');
        $nips = request('list-pegawai');
        try {
            $this->lokasiKerjaRepository->saveManageLokasiKerja($kodeLokasi,$nips);
            return response()->json(["status"=>true,"msg"=>"Berhasil, menambahkan pegawai!"]);
        } catch (\Throwable $th) {
            return response()->json(["status"=>false,"msg"=>$th->getMessage()]);
            //throw $th;
        }
    }
    function detail($kode_lokasi,$kode_skpd){
        return view('pages.manage_lokasi_kerja.detail',compact('kode_lokasi','kode_skpd'));
    }
    function delete(MapLokasiKerja $mapLokasiKerja){
        try {
            $mapLokasiKerja->delete();
            return response()->json(["status"=>true,"msg"=>"Berhasil, dihapus!"]);
        } catch (\Throwable $th) {
            return response()->json(["status"=>false,"msg"=>$th->getMessage()]);
            //throw $th;
        }
    }
    function datatable(Datatables $dataTables){
        $kodeSkpd = request()->query('kode_skpd');
        $lokasiKerja = $this->lokasiKerja;
        if($kodeSkpd){
            $lokasiKerja = $lokasiKerja->where('kode_skpd',$kodeSkpd);
        }
        return $dataTables->of($lokasiKerja->get())
        ->addColumn('divisi', function ($row) {
            $lokasiDetail = LokasiDetail::where([
                'kode_lokasi' => $row->kode_lokasi,
                'keterangan_tipe'=>3,
            ])->first();
            $kodeSkpd = $lokasiDetail?->keterangan_id;
            return Skpd::where('kode_skpd',$kodeSkpd)->first()?->nama ?? "-";

        })
        ->addColumn('total_pegawai',function ($row) {

            return '<span class="badge badge-info">'.$row->mapLokasiKerja->count().'</span>';
        })
        ->addColumn('opsi',function ($row) {
            $lokasiDetail = LokasiDetail::where([
                'kode_lokasi' => $row->kode_lokasi,
                'keterangan_tipe'=>3,
            ])->first();
            $kodeSkpd = $lokasiDetail?->keterangan_id;
            $skpd = Skpd::where('kode_skpd',$kodeSkpd)->first();
            return $skpd ? "<a class='me-2 edit' tooltip='Manage Pegawai ke Lokasi Kerja' href='" . route('manage_lokasi_kerja.detail', ['kode_lokasi' => $row->kode_lokasi,'kode_skpd'=>$kodeSkpd]) . "'>" . icons('cogs') . "</a>" : "-";
        })
        ->addIndexColumn()
        ->rawColumns(['opsi','total_pegawai'])
        ->toJson();
    }
    function datatable_detail(Datatables $dataTables){
        $kode_lokasi = request()->query('kode_lokasi');
        $manageLokasiKerja = $this->lokasiKerjaRepository->getPegawai($kode_lokasi);
        // dd($manageLokasiKerja);
        $pegawai = $manageLokasiKerja->get()->pluck('nip')->toArray();
        // dd($pegawai);
        $pegawai = User::whereIn('nip',$pegawai);
        return $dataTables->of($pegawai->get())

        ->addColumn('name',function ($row) {
            return '<b class="text-primary">' . $row->nip . '</b> ' .  $row->getFullName();
        })
        ->addColumn('nama_jabatan', function ($row) {
            return '<p>'.$row->getNamaDivisi().'</p><p>'.$row->getNamaJabatan().'</p>';
        })
        ->addColumn('opsi',function ($row) {
            return "<a class='delete text-danger delete' tooltip='Hapus' href='" . route('manage_lokasi_kerja.delete', $row->id) . "'>" . icons('trash') . "</a>";
        })

        ->addIndexColumn()
        ->rawColumns(['opsi','name','nama_jabatan'])
        ->toJson();
    }
}
