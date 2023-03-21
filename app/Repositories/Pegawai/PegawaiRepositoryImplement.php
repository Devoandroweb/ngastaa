<?php

namespace App\Repositories\Pegawai;

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
    function getAllPegawaiRoleOPD($role){
        
        return $this->allPegawai($role)->get();
    }
    function getOnePegawaiRoleOPD($role,$nip){
        foreach ($this->allPegawai($role)->get() as $pegawai) {
            if($nip == $pegawai->nip){
                return $pegawai;
            }
        }
        return null;
    }
    function getWhereNotInPegawaiRoleOPD($role,$nip = []){
        $pegawaiSpesific = $this->allPegawai($role)->whereNotIn('nip',$nip)->get();
        return $pegawaiSpesific;
    }
    function allPegawai($role){
        return $this->allPegawai = User::role('pegawai')
            ->when($role, function ($qr) {
                $user = auth()->user()->jabatan_akhir;
                $jabatan = array_key_exists('0', $user->toArray()) ? $user[0] : null;
                $skpd = '';
                if ($jabatan) {
                    $skpd = $jabatan->kode_skpd;
                }
                $qr->join('riwayat_jabatan', function ($qt) use ($skpd) {
                    $qt->on('riwayat_jabatan.nip', 'users.nip')
                        ->where('riwayat_jabatan.kode_skpd', $skpd)
                        ->where('riwayat_jabatan.is_akhir', 1);
                });
            });
    }
    function getAllPegawai(){
         return $this->allPegawai = User::role('pegawai')->get();
    }
    // Write something awesome :)
}
