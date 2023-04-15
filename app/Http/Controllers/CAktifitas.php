<?php

namespace App\Http\Controllers;

use App\Models\MAktifitas;
use App\Models\Master\Lokasi;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CAktifitas extends Controller
{
    //
    public function index()
    {
        $lokasiKerja = Lokasi::select('nama','polygon')->get();
        $dataLokasi = [];
        foreach ($lokasiKerja as $lokasi) {
            $dataPolygon = [];
            $polygon = json_decode($lokasi->polygon);
            // dd($polygon);
            // die();
            if($polygon != null){
                // dd("ada");
                foreach ($polygon[0] as $gon) {
                    $dataPolygon[] = [$gon->lng,$gon->lat];
                    // dd($gon);
                }
            }
            $dataLokasi[] = ['nama'=>$lokasi->nama,'polygon'=>$dataPolygon,'polygonAsli'=>$lokasi->polygon];
;        }
        return view('pages/daftarpresensi/aktifitas/index',compact('dataLokasi'));
    }
    function datatable(DataTables $dataTables){
        $aktivitas = MAktifitas::with('pegawai')->orderBy('created_at','desc')->get();
        return $dataTables->of($aktivitas)
        ->addColumn('nama_pegawai', function ($row) {
            return "<span class='badge badge-success badge-pill badge-sm'>". $row->nip . "</span>  " . $row->pegawai->getFullName();
        })
        ->addColumn('jabatan', function ($row) {
            $jabatan_akhir = $row->pegawai->jabatan_akhir;
            $jabatan = array_key_exists('0', $jabatan_akhir->toArray()) ? $jabatan_akhir[0] : null;
            
            // dd($jabatan);
            $nama_jabatan = '-';
            if ($jabatan) {
                $tingkat = $jabatan?->tingkat;
                $nama_jabatan =  $tingkat?->nama;
                return $nama_jabatan;
            }
            return $nama_jabatan;
        })
        ->editColumn('created_at',function($row){
            return tanggal_indo($row->created_at);
        })
        ->addColumn('opsi', function ($row) {
            $html = "<a class='me-2 edit' tooltip='Edit' href='" . route('pegawai.cuti.edit', ['pegawai' => $row['nip'], 'Rcuti' => $row['id']]) . "'>" . icons('pencil') . "</a>";
            return $html;
        })
        ->rawColumns(['opsi', 'nama_pegawai'])
        ->addIndexColumn()->toJson();
    }
}
