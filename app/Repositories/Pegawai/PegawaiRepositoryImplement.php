<?php

namespace App\Repositories\Pegawai;

use App\Models\Master\Eselon;
use App\Models\Master\Tingkat;
use App\Models\Pegawai\RiwayatJabatan;
use App\Models\Presensi\TotalPresensi;
use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\User;
use App\Models\VPegawai;
use Illuminate\Support\Facades\Auth;

class PegawaiRepositoryImplement extends Eloquent implements PegawaiRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $mUser;
    protected $role;
    protected $allPegawai;

    public function __construct(User $mUser)
    {

        $this->mUser = $mUser;
    }
    function allPegawaiWithRole1($kodeSkpd = null, $forApi = false){

        if(role('pegawai')){
            $kodeSkpd = auth()->user()->jabatan_akhir->first()?->skpd?->kode_skpd;
        }
        // dd($kodeSkpd);
        if($forApi){
            # FOR WEB_SERVICES
            $role = false;
            $user = User::where('nip',request()->query('nip'))->first();
            $levelJabatanUser = $user->jabatan_akhir->first()?->tingkat?->eselon->kode_eselon;
        }else{
            # FOR WEB
            $role = role('owner') || role('admin') || role("finance");
            $levelJabatanUser = auth()->user()->jabatan_akhir->first()?->tingkat?->eselon->kode_eselon;
            // dd($levelJabatanUser);
        }

        $pegawai = User::whereNot('users.nip',null)->with('riwayat_jabatan');

        // dd(getLevelUser());

        if(getLevelUser() == "5"){ # Pegawai
            $pegawai->where('created_by',getIdUser());
        }
        $pegawai->when(!$role, function ($qr) use ($levelJabatanUser,$kodeSkpd){
            // ambil level jabatan user
            // dd($kodeSkpd);
            // ambil jabatan yang di bawah level jabatan user misal jabatannya level 2 maka ambil pegawai where kode_level < level_jabatan_user
            $qr->whereHas('riwayat_jabatan',function($q)use ($levelJabatanUser, $kodeSkpd){
                if($kodeSkpd != 0 || $kodeSkpd != null){
                    $q->where('kode_skpd',$kodeSkpd);
                }
                $q->where('is_akhir',1);
                $q->whereHas('tingkat',function($q) use ($levelJabatanUser){
                    $q->whereHas('eselon',function($q)  use ($levelJabatanUser){
                        $q->where('kode_eselon','>',(int)$levelJabatanUser);
                    });
                });
            });
        });
        // dd($role,$kodeSkpd);
        if($role){
            // dd($kodeSkpd);
            if($kodeSkpd != 0){
                $pegawai->join('riwayat_jabatan', function ($qt) use ($kodeSkpd) {
                    // dd($where);
                    $qt->on('riwayat_jabatan.nip', 'users.nip');
                    // dd($kodeSkpd != null,$kodeSkpd != 0,$kodeSkpd);
                    if($kodeSkpd != null && $kodeSkpd != 0){
                        $qt->where([
                            "is_akhir" => 1,
                            "kode_skpd" => $kodeSkpd
                        ]);
                    }
                    $qt->where('riwayat_jabatan.deleted_at', null);
                    // dd($kodeSkpd);
                });
            }

        }
        return $pegawai;
    }
    function allPegawaiWithRole($kodeSkpd = null, $forApi = false){
        if(config("app.hit_v_pegawai")){
            return $this->getVPegawaiWithRole($kodeSkpd,$forApi);
        }
        if(role('pegawai')){
            $kodeSkpd = auth()->user()->jabatan_akhir->first()?->skpd?->kode_skpd;
        }
        // dd($kodeSkpd);
        if($forApi){
            # FOR WEB_SERVICES
            $role = false;
            $user = User::where('nip',request()->query('nip'))->first();
            $levelJabatanUser = $user->jabatan_akhir->first()?->tingkat?->eselon->kode_eselon;
        }else{
            # FOR WEB
            $role = role('owner') || role('admin') || role("finance");
            $levelJabatanUser = auth()->user()->jabatan_akhir->first()?->tingkat?->eselon->kode_eselon;
            // dd($levelJabatanUser);
        }

        $pegawai = User::whereNot('users.nip',null)->with('riwayat_jabatan');

        // dd(getLevelUser());

        if(getLevelUser() == "5"){ # Pegawai
            $pegawai->where('created_by',getIdUser());
        }
        $pegawai->when(!$role, function ($qr) use ($levelJabatanUser,$kodeSkpd){
            // ambil level jabatan user
            // dd($kodeSkpd);
            // ambil jabatan yang di bawah level jabatan user misal jabatannya level 2 maka ambil pegawai where kode_level < level_jabatan_user
            $qr->whereHas('riwayat_jabatan',function($q)use ($levelJabatanUser, $kodeSkpd){
                if($kodeSkpd != 0 || $kodeSkpd != null){
                    $q->where('kode_skpd',$kodeSkpd);
                }
                $q->where('is_akhir',1);
                $q->whereHas('tingkat',function($q) use ($levelJabatanUser){
                    $q->whereHas('eselon',function($q)  use ($levelJabatanUser){
                        $q->where('kode_eselon','>',(int)$levelJabatanUser);
                    });
                });
            });
        });

        if($role){
            // dd($kodeSkpd);
            if($kodeSkpd != 0){
                $pegawai->join('riwayat_jabatan', function ($qt) use ($kodeSkpd) {
                    // dd($where);
                    $qt->on('riwayat_jabatan.nip', 'users.nip');
                    // dd($kodeSkpd != null,$kodeSkpd != 0,$kodeSkpd);
                    if($kodeSkpd != null && $kodeSkpd != 0){
                        $qt->where([
                            "is_akhir" => 1,
                            "kode_skpd" => $kodeSkpd
                        ]);
                    }
                    $qt->where('riwayat_jabatan.deleted_at', null);
                    // dd($kodeSkpd);
                });
            }
        }
        return $pegawai;
    }
    function getAllPegawai(){
         return User::where('owner',0)->get();
    }
    // Write something awesome :)
    function updatoOrCreatoToTotalPresensi(){
        foreach($this->getAllPegawai() as $pegawai){
            TotalPresensi::firstOrCreate([
                'nip' => $pegawai->nip,
                'periode_bulan' => date("Y-m")
            ]);
            // $cr->assignRole('pegawai');

        }
    }
    function getFirstPegawai($nip){

        $pegawai = User::where('users.nip', $nip)
            ->first();
            // dd($pegawai);
        return $pegawai;
    }
    function getPegawaiWhereJabatan($kodeJabatan) {
        $riwayatJabatan = RiwayatJabatan::whereIn('kode_tingkat',$kodeJabatan)->where('is_akhir',1)->get();
        return $riwayatJabatan;
    }
    function getPegawaiWhereLevelJabatan($kodeEselon){
        $kodeTingkat = Tingkat::whereIn('kode_eselon',$kodeEselon)->get()->pluck('kode_tingkat')->toArray();
        $riwayatJabatan = RiwayatJabatan::whereIn('kode_tingkat',$kodeTingkat)->where('is_akhir',1)->get();
        return $riwayatJabatan;
    }
    function getPegawaiWhereDivisiKerja($kodeSkpd) {
        $riwayatJabatan = RiwayatJabatan::whereIn('kode_skpd',$kodeSkpd)->where('is_akhir',1)->get();
        return $riwayatJabatan;
    }
    function getVPegawaiWithRole($kodeSkpd = null, $forApi = false){
        if(role('pegawai')){
            $kodeSkpd = auth()->user()->jabatan_akhir->first()?->skpd?->kode_skpd;
        }
        // dd($kodeSkpd);
        if($forApi){
            # FOR WEB_SERVICES
            $role = false;
            $user = request()->user();

            $levelJabatanUser = $user->jabatan_akhir->first()?->tingkat?->eselon->kode_eselon;
        }else{
            # FOR WEB
            // $role = role('owner') || role('admin') || role("finance");
            $role = role('owner') || role('admin') || role("finance");
            $levelJabatanUser = auth()->user()->jabatan_akhir->first()?->tingkat?->eselon->kode_eselon;
            // dd($levelJabatanUser);
        }
        $pegawai = VPegawai::where("deleted_at",null);
        if($kodeSkpd){
            $pegawai->where("kode_skpd",$kodeSkpd);
        }
        return $pegawai;
    }
}
