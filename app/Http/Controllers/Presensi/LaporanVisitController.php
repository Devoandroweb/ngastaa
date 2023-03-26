<?php

namespace App\Http\Controllers\Presensi;

use App\Http\Controllers\Controller;
use App\Models\Master\Visit;
use App\Models\Pegawai\DataVisit;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class LaporanVisitController extends Controller
{
    function index(){
        $lokasiKerja = Visit::select('nama','polygon')->get();
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
        return view("pages.daftarpresensi.laporanvisit.index",compact('dataLokasi'));
    }
    function datatable(DataTables $dataTables){
        $nip = request('nip');
        $skpd = request()->query('skpd');
        $skpd = ($skpd == 0) ? null : $skpd;
        // $skpd = 1;
        $model = DataVisit::with('pegawai')->when($skpd,function($q){
                $jabatan_akhir = $q->pegawai->jabatan_akhir;
                $jabatan = array_key_exists('0', $jabatan_akhir->toArray()) ? $jabatan_akhir[0] : null;
                $skpd = '';
                if ($jabatan) {
                    $skpd = $jabatan->kode_skpd;
                }
                $q->join('riwayat_jabatan', function ($qt) use ($skpd) {
                    $qt->on('riwayat_jabatan.nip', 'users.nip')
                        ->where('riwayat_jabatan.kode_skpd', $skpd)
                        ->where('riwayat_jabatan.is_akhir', 1);
                });
        });
        return $dataTables->of($model)
            ->editColumn('shift', function ($row) {
                return $row->nama_shift;
            })
            ->addColumn('nama', function ($row) {
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
            ->addColumn('tanggal', function ($row) {
                return tanggal_indo($row->created_at);
            })
            ->rawColumns(['nama'])
            ->addIndexColumn()
            ->toJson();
    }
}
