<?php

namespace App\Http\Controllers;

use App\Models\MapLokasiKerja;
use App\Models\Master\Skpd;
use App\Repositories\LokasiKerja\LokasiKerjaRepository;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ManageLokasiKerja extends Controller
{
    protected $lokasiKerjaRepository;
    protected $skpd;
    function __construct(
        LokasiKerjaRepository $lokasiKerjaRepository,
        Skpd $skpd
    ){
        $this->lokasiKerjaRepository = $lokasiKerjaRepository;
        $this->skpd = $skpd;
    }
    function index(){
        $skpd = $this->skpd->get();
        return view('pages.manage_lokasi_kerja.index',compact('skpd'));
    }
    function detail($kode_lokasi){
        return view('pages.manage_lokasi_kerja.detail',compact('kode_lokasi'));
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
        $skpd = $this->skpd;
        if($kodeSkpd){
            $skpd = $skpd->where('kode_skpd',$kodeSkpd);
        }
        return $dataTables->of($skpd)
        ->addColumn('action',function ($row) {
            $html = "<a class='me-2 edit' tooltip='Manage Role Menu' href='" . route('manage_lokasi_kerja.delete', $row->id) . "'>" . icons('cogs') . "</a>";

        })
        ->addIndexColumn()
        ->rawColumns(['action'])
        ->toJson();
    }
    function datatable_detail(Datatables $dataTables){
        $kode_lokasi = request()->query('kode_lokasi');
        $manageLokasiKerja = $this->lokasiKerjaRepository->getPegawai($kode_lokasi)->first();
        $pegawai = $manageLokasiKerja->pegawai;
        return $dataTables->of($pegawai)
        ->addColumn('action',function ($row) {
            return "<a class='delete text-danger delete' tooltip='Hapus' href='" . route('manage_lokasi_kerja', $row->id) . "'>" . icons('trash') . "</a>";
        })
        ->addIndexColumn()
        ->rawColumns(['action'])
        ->toJson();
    }
}
