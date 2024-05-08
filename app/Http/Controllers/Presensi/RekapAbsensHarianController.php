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
    protected $mTotalPresensiDetail;
    protected $hadir;

    public function index()
    {
        $skpd = Skpd::all();
        $statusPresensi = [
            ['status'=>"1",'description'=>'Hadir'],
            ['status'=>"2",'description'=>'Telat'],
            ['status'=>"3",'description'=>'Alfa'],
            ['status'=>"4",'description'=>'Izin'],
            ['status'=>"5",'description'=>'Tanpa Absen Pulang'],
            ['status'=>"6",'description'=>'Pulang Cepat'],
            ['status'=>"7",'description'=>'Piket'],
        ];
        return view('pages.daftarpresensi.rekapabsenharian.index',compact('skpd','statusPresensi'));
    }

    public function datatable(Request $request)
    {
        $search = request()->query('search')['value'];
        $kodeSkpd = request()->query('kode_skpd');

        $date_start = date('Y-m-01');
        $date_end = date('Y-m-t');
        $periodeBulan = date("Y-m");

        // dd(request()->query('date_start') && request()->query('date_end'));
        if (request()->query('date_start') && request()->query('date_end') ) {
            $date_start = date("Y-m-d",strtotime(request()->query('date_start')));
            $date_end = date("Y-m-d",strtotime(request()->query('date_end')));
            $periodeBulan = null;
        }

        $tanggal_awal_akhir = new DatePeriod(
            new DateTime($date_start),
            new DateInterval('P1D'),
            new DateTime($date_end."+1 Days")
        );

        // dd($tanggal_awal_akhir->format('Y-m-d'));
        // foreach ($tanggal_awal_akhir as $tanggal ) {
        //     echo $tanggal->format("Y-m-d");
        // }
        // dd("oke");
        $rawColumn = [];
        // dd(User::where('name','like','%a%')->get());
        // dd($kodeSkpd);

        $mUsers = User::where('owner',0)->when($search,function($q)use($search){
                        return $q->where('users.name','like','%'.$search.'%');
                    })->when(($kodeSkpd  != 0),function($q)use($kodeSkpd){
                        return $q->whereHas('riwayat_jabatan',function ($q)use($kodeSkpd){
                                    $q->where('is_akhir',1);
                                    $q->where('kode_skpd',$kodeSkpd);
                                });
                    });
        // dd($mUsers->get(),$kodeSkpd);
        if($periodeBulan != null){
            $this->mTotalPresensiDetail = TotalPresensiDetail::whereBetween('tanggal',[$date_start, $date_end])
                        ->where('periode_bulan',$periodeBulan)->get();
        }else{
            $this->mTotalPresensiDetail = TotalPresensiDetail::whereBetween('tanggal',[$date_start, $date_end])->get()  ;
        }
        // dd($this->mTotalPresensiDetail,$periodeBulan,$mUsers->get()->count());
        if($mUsers->get()->count() == 0){
            $mUsers = User::role('pegawai')->when($search,function($q)use($search){
                        return $q->where('users.name','like','%'.$search.'%');
                    });
            // dd($mUsers->get()->count());
            $dt = DataTables::of($mUsers);
            foreach ($tanggal_awal_akhir as $tanggal ) {
                $rawColumn[] = "day_{$tanggal->format('d')}";
                $dt->addColumn("day_{$tanggal->format('d')}", function($row)use($tanggal,$rawColumn){
                    return '-';
                });
            }
            $dt->addColumn('rekap',function($row){
                return 0;
            });
        }else{
            // dd($mUsers->get());

            $dt = DataTables::of($mUsers);

            foreach ($tanggal_awal_akhir as $i => $tanggal ) {

                $rawColumn[] = "day_{$tanggal->format('d')}";
                // $this->hadir = 0;
                $dt->addColumn("day_{$tanggal->format('d')}", function($row)use($tanggal,$i){
                    $status = $this->getStatusInmTotalPresensiDetail($tanggal->format('Y-m-d'),$row->nip);
                    $status = explode(",",$status);
                    if($status[0] == ""){
                        $status = [];
                    }
                    if (count($status) > 0) {
                        $badgeStatus = "";
                        foreach ($status as $value) {
                            $badgeStatus .= generateStatusAbsen($value);
                        }
                        return $badgeStatus;
                    }else {
                        $hariSabtuMinggu = cekHariAkhirPekan($tanggal->format('Y-m-d'));
                        $hariLibur = cekHariLibur($tanggal->format('Y-m-d'));
                        // dd($this->dataPresensi);
                        if($hariLibur || $hariSabtuMinggu){
                            return '<span class="badge badge-warning badge-pill badge-outline">L</span>';
                        }
                        return '-';
                    }
                });
            }
            $dt->addColumn('rekap',function($row) use ($tanggal_awal_akhir){
                $hadir = 0;
                foreach ($tanggal_awal_akhir as $i => $tanggal ) {
                    // $this->hadir = 0;

                    $status = $this->getStatusInmTotalPresensiDetail($tanggal->format('Y-m-d'),$row->nip);
                    // dd($status)
                    $status = collect(explode(",",$status));
                    $statusPresensi = collect(["1","2","5","6","7"]);
                    if ($status->count() != 0) {
                        $intersect = $status->intersect($statusPresensi);
                        if($intersect->isNotEmpty()){
                            $hadir++;
                        }
                    }

                }
                return $hadir;
            });
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
    function getStatusInmTotalPresensiDetail($tanggal,$nip)
    {
        // dd($this->mTotalPresensiDetail);
        $result = null;
        foreach ($this->mTotalPresensiDetail as $value) {
            if($tanggal == $value->tanggal && $nip == $value->nip){
                $result = $value->status;
                return $result;
            }
        }
        return $result;
    }

}
