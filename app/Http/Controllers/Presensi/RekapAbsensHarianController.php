<?php

namespace App\Http\Controllers\Presensi;

use App\Http\Controllers\Controller;
use App\Models\Master\Skpd;
use App\Models\Presensi\TotalPresensiDetail;
use App\Models\User;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class RekapAbsensHarianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $skpd = Skpd::all();
        return view('pages.daftarpresensi.rekapabsenharian.index',compact('skpd'));
    }

    public function datatable(Request $request)
    {
        $search = request()->query('search')['value'];

        $date_start = date('Y-m-01');
        $date_end = date('Y-m-t');
        // dd(request()->query('date_start') && request()->query('date_end'));
        if (request()->query('date_start') && request()->query('date_end') ) {
            $date_start = date("Y-m-d",strtotime(request()->query('date_start')));
            $date_end = date("Y-m-d",strtotime(request()->query('date_end')));
        }
        $tanggal_awal_akhir = new DatePeriod(
            new DateTime($date_start),
            new DateInterval('P1D'),
            new DateTime($date_end."+1 Days")
        );
        // dd($date_start,$date_end);
        // dd($tanggal_awal_akhir->format('Y-m-d'));
        // foreach ($tanggal_awal_akhir as $tanggal ) {
        //     echo $tanggal->format("Y-m-d");
        // }
        // dd("oke");
        $rawColumn = [];
        // dd(User::where('name','like','%a%')->get());
        $Tpresensi = User::role('pegawai')->when($search,function($q)use($search){
                        // dd($search);
                        return $q->where('users.name','like','%'.$search.'%');
                    })->join('total_presensi_detail','total_presensi_detail.nip','=','users.nip')->whereBetween('tanggal',[$date_start, $date_end]);
        // dd($Tpresensi);
        // dd($Tpresensi->get());
        if($Tpresensi->get()->count() == 0){
            $Tpresensi = User::role('pegawai')->when($search,function($q)use($search){
                        return $q->where('users.name','like','%'.$search.'%');
                    });
            $dt = DataTables::of($Tpresensi);
            foreach ($tanggal_awal_akhir as $tanggal ) {
                $rawColumn[] = "day_{$tanggal->format('d')}";
                $dt->addColumn("day_{$tanggal->format('d')}", function($row)use($tanggal,$rawColumn){
                    return '-';
                });
            }
        }else{
            $dt = DataTables::of($Tpresensi);
            foreach ($tanggal_awal_akhir as $tanggal ) {
                $rawColumn[] = "day_{$tanggal->format('d')}";
                $dt->addColumn("day_{$tanggal->format('d')}", function($row)use($tanggal){
                    if ($tanggal->format('Y-m-d') == $row->tanggal) {
                        return generateStatusAbsen($row->status);
                    }else {
                        return '-';
                    }
                });
            }
        }
        $dt->addColumn('jabatan',function($row){
            $jabatan = array_key_exists('0', $row->jabatan_akhir->toArray()) ? $row->jabatan_akhir[0] : null;
            $tingkat = $jabatan?->tingkat;
            $nama_jabatan =  $tingkat?->nama;
            return $nama_jabatan ?? "-";
        });
        $dt->addColumn('nama_pegawai',function($row){
            return $row->getFullName();
        });
        $dt->rawColumns($rawColumn);
        $dt->addIndexColumn();
        return $dt->toJson();
    }
    
}
