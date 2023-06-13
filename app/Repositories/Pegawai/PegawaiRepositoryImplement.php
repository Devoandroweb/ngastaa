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
    function allPegawaiWithRole($levelJabatanUser = null, $kodeSkpd = null){
        $role = role('owner') || role('admin');
        $pegawai = User::role('pegawai')->whereNot('users.nip',null)->with('riwayat_jabatan')
        ->when(!$role, function ($qr) use ($levelJabatanUser){
            // ambil level jabatan user
            // ambil jabatan yang di bawah level jabatan user misal jabatannya level 2 maka ambil pegawai where kode_level < level_jabatan_user
            $qr->whereHas('riwayat_jabatan',function($q)use ($levelJabatanUser){
                $q->where('is_akhir',1);
                $q->whereHas('tingkat',function($q) use ($levelJabatanUser){
                    $q->whereHas('eselon',function($q)  use ($levelJabatanUser){
                        $q->where('kode_eselon',">",$levelJabatanUser);
                    });
                });
            });
        });
        return $pegawai;
    }
    function getAllPegawai(){
         return User::role('pegawai')->get();
    }
    // Write something awesome :)
    function updatoOrCreatoToTotalPresensi(){
        foreach($this->getAllPegawai() as $pegawai){
            TotalPresensi::firstOrCreate([
                'nip' => $pegawai->nip,
                'periode_bulan' =>  date("Y-m")
            ]);
            // $cr->assignRole('pegawai');

        }
    }
}
