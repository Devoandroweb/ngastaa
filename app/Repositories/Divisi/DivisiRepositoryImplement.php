<?php

namespace App\Repositories\Divisi;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Divisi;
use App\Models\Master\Skpd;
use App\Repositories\Pegawai\PegawaiRepository;

class DivisiRepositoryImplement extends Eloquent implements DivisiRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Skpd|mixed $model;
    */
    protected $skpd;
    protected $pegawaiRepository;

    public function __construct(
        Skpd $skpd,
        PegawaiRepository $pegawaiRepository
    )
    {
        $this->skpd = $skpd;
        $this->pegawaiRepository = $pegawaiRepository;
    }
    function allDivisionWithRole(){
        $nip = null;
        $result = null;

        if(!role('owner') && !role('admin') && !role('finance')){
            if(role('level_2')){
                $nip = $this->pegawaiRepository->allPegawaiWithRole()->pluck('nip')->toArray();
            }
            $nip[] = auth()->user()->nip;
            $result = $this->skpd->whereIn('pemilik',$nip)->orderBy('nama');
        }else{
            $result = $this->skpd->orderBy('nama');
        }
        return $result;
    }
    function updateOrCreate($id,$data){
        try {
            //code...
            if(!role('owner') || !role('admin')){
                $nip = auth()->user()->nip;
                $data['pemilik'] = $nip;
            }
            $this->skpd->updateOrCreate(['id' => $id], $data);
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    // Write something awesome :)
}
