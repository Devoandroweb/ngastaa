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
        // $index = searchIndexArrayAssoc("nama_pegawai","data",request("columns"));
        // dd(request('search'));
        $aktivitas = MAktifitas::whereHas('pegawai',function($q){
            if(request('search')["value"]){
                $q->where("name","like","%".request('search')['value']."%");
            }
        })->orderBy('created_at','desc')->get();
        return $dataTables->of($aktivitas)
        ->editColumn("foto",function ($row){
            return $row->foto();
        })
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
        ->editColumn('jam_mulai',function($row){
            return date("H:i:s",strtotime($row->jam_mulai));
        })
        ->editColumn('jam_selesai',function($row){
            return date("H:i:s",strtotime($row->jam_selesai));
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
