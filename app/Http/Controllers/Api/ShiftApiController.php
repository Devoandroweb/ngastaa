<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\PegawaiResource;
use App\Http\Resources\Pegawai\RiwayatShiftResource;
use App\Http\Resources\Select\SelectResource;
use App\Models\Master\Shift;
use App\Models\Pegawai\RiwayatShift;
use App\Models\User;
use App\Repositories\Pegawai\PegawaiRepository;

class ShiftApiController extends Controller
{
    protected $pegawaiRepository;
    protected $pegawaiWithRole;
    function __construct(
        PegawaiRepository $pegawaiRepository
    ){
        $this->pegawaiRepository = $pegawaiRepository;
    }
    public function index()
    {
        $shift = Shift::orderBy('nama')->get();
        SelectResource::withoutWrapping();
        $shift = SelectResource::collection($shift);
        return response()->json(buildResponseSukses($shift),200);
    }


    public function store()
    {
        $nip = request('nip');
        $kode_shift = request('kode_shift');
        $keterangan = request('keterangan');
        $untukTanggal = date("Y-m-d",strtotime(request('untuk_tanggal')));
        $sampaiTanggal = date("Y-m-d",strtotime(request('sampai_tanggal')));

       if (request()->file('file')) {
            $file =  request()->file('file');
            $namaFile = uploadImage(public_path("shift/$nip"),$file);
        }else{
            $namaFile = "";
        }

        $user = User::where('nip', $nip)->first();
        if($user){
                $data = [
                    'nip' => $nip,
                    'kode_shift' => $kode_shift,
                    'keterangan' => $keterangan,
                    'file' => "shift/$nip/".$namaFile,
                    'untuk_tanggal'=>"$untukTanggal,$sampaiTanggal"
                ];

                $cek = RiwayatShift::where('nip', $nip)->where('status', 0)->count();
                if($cek > 0){
                    return response()->json(buildResponseSukses(['status' => FALSE, 'messages' => 'Anda telah melakukan pengajuan sebelumnya!']),200);
                }

                $cr = RiwayatShift::create($data);
                if($cr){
                    tambah_log($cr->nip, "App\Pegawai\RiwayatShift", $cr->id, 'diajukan');
                    return response()->json(buildResponseSukses(['status' => TRUE,'messages' => 'Berhasil mengajukan Shift']),200);
                }else{
                    return response()->json(buildResponseSukses(['status' => FALSE,'messages' => 'Gagal mengajukan Shift']),200);
                }
        }else{
            return response()->json(buildResponseSukses(['status' => FALSE,'messages' => 'Pengguna tidak di temukan']),200);
        }
    }

    public function detail()
    {
        $id = request('id');
        if($id){
            $dpc = RiwayatShift::where('id', $id)->first();
            if($dpc){
                $user = User::where('nip', $dpc->nip)->first();
                if($user){
                    return response()->json(buildResponseSukses([
                        'user' => PegawaiResource::make($user),
                        'data' => $dpc,
                    ]),200);
                }else{
                    return response()->json(buildResponseSukses(['status' => FALSE]),200);
                }
            }else{
                return response()->json(buildResponseSukses(['status' => FALSE]),200);
            }
        }else{
            return response()->json(buildResponseSukses(['status' => FALSE]),200);
        }
    }

    public function lists()
    {
        $nip = request('nip');
        $user = User::where('nip', $nip)->first();
        if($user){
            $dpc = RiwayatShift::where('nip', $nip)->where('status', '!=', 99)->orderBy('created_at','desc')->paginate(10);
            if($dpc){
                    return response()->json(buildResponseSukses([
                        'user' => PegawaiResource::make($user),
                        'data' => RiwayatShiftResource::collection($dpc),
                    ]),200);
            }else{
                return response()->json(buildResponseSukses(['status' => FALSE, 'messages' => 'Anda tidak memiliki pengajuan!' ]),200);
            }
        }else{
            return response()->json(buildResponseSukses(['status' => FALSE, 'messages' => 'User tidak ditemukan!']),200);
        }
    }
    public function listsOpd()
    {
        $nip = request()->query('nip');
        $kodeSkpd = request()->query('kode_skpd');

        $user = User::where('nip',$nip)->first();
        if(!$user){
            return response()->json(buildResponseSukses(['status'=>false,'messages'=>'NIP tidak di temukan']),200);
        }
            // dd($opd);
        $arrayNip = $this->pegawaiRepository->allPegawaiWithRole($kodeSkpd,true)->pluck('nip')->toArray();
        if($user){
            $dpc = RiwayatShift::with('user')->whereIn('nip', $arrayNip)->where('status', 1)->orderBy('created_at','desc')->paginate(10);
            if($dpc){
                    return response()->json(buildResponseSukses([
                        'user' => PegawaiResource::make($user),
                        'data' => RiwayatShiftResource::collection($dpc),
                    ]),200);
            }else{
                return response()->json(buildResponseSukses(['status' => FALSE, 'messages' => 'Anda tidak memiliki pengajuan!' ]),200);
            }
        }else{
            return response()->json(buildResponseSukses(['status' => FALSE, 'messages' => 'User tidak ditemukan!']),200);
        }
    }
    function listMasterShift($nip){
        $user = $this->pegawaiRepository->getFirstPegawai($nip);
        $shift = Shift::where('kode_skpd',$user->getDivisi()->kode_skpd)->get();
        return response()->json(buildResponseSukses([
            'data' => $shift,
        ]),200);
    }
    function storeUbahShift(){
        try {
            $nip = request('nip');
            $kodeShift = request('kode_shift');
            $kodeShiftAktif = request('kode_shift_aktif');
            $tanggal = date("Y-m-d");

            $data = ['nip'=>$nip,'kode_shift'=>$kodeShift,'tanggal_surat'=>$tanggal,'is_akhir'=>1,'status'=>1];

            $shiftAktif = Shift::where('kode_shift',$kodeShiftAktif)->first();
            if($shiftAktif){
                if(strtotime($shiftAktif->jam_tepat_datang) > strtotime(date("H:i:s"))){
                    RiwayatShift::where(['nip'=>$nip])->update(['is_akhir'=>0]);
                    RiwayatShift::updateOrCreate($data);
                }else{
                    return response()->json(buildResponseSukses(['status' => TRUE, 'messages' => 'Anda Sudah dalam jam Shift']),200);
                }
            }else{
                return response()->json(buildResponseSukses(['status' => TRUE, 'messages' => 'Anda tidak punya shift']),200);
            }

            return response()->json(buildResponseSukses(['status' => TRUE, 'messages' => 'Berhasil ubah Shift']),200);
        } catch (\Throwable $th) {
            return response()->json(buildResponseGagal(['status' => FALSE, 'messages' => $th->getMessage()]),400);
            //throw $th;
        }

    }
}
