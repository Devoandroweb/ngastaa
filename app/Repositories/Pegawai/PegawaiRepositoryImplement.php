<?php

namespace App\Repositories\Pegawai;

use App\Models\Presensi\TotalPresensi;
use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\User;
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
    function allPegawaiWithRole($kodeSkpd = null, $forApi = false){
        // $pegawai = User::all();
        // foreach ($pegawai as $value) {
        //     $value->assignRole('pegawai');
        // }
        // dd("done");
        if(role('pegawai')){
            $kodeSkpd = auth()->user()->jabatan_akhir->first()?->skpd?->kode_skpd;
        }
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
        // dd(User::role('pegawai')->get());
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
        if($role && $kodeSkpd != 0){
            $pegawai->join('riwayat_jabatan', function ($qt) use ($kodeSkpd) {
                $qt->on('riwayat_jabatan.nip', 'users.nip')
                ->where('is_akhir', 1)
                ->where('riwayat_jabatan.deleted_at', null);
                // dd($kodeSkpd);
                if($kodeSkpd != null && (int)$kodeSkpd != 0){
                    $qt->where('kode_skpd', $kodeSkpd);
                }
            });
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
}
