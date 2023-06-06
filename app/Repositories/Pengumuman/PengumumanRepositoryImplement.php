<?php

namespace App\Repositories\Pengumuman;

use App\Http\Resources\PengumumanResource;
use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Pengumuman;

class PengumumanRepositoryImplement extends Eloquent implements PengumumanRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Pengumuman|mixed $mPengumuman;
    */
    protected $mPengumuman;
    protected $pengumumanResource;

    public function __construct(
        Pengumuman $mPengumuman,
    )
    {
        $this->mPengumuman = $mPengumuman;
    }
    function getPengumuman(){

        return PengumumanResource::collection($this->mPengumuman->latest()->get());
    }
    // Write something awesome :)
}
