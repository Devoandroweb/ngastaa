<?php

namespace App\Repositories\RekapPresensiHarian;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\RekapPresensiHarian;

class RekapPresensiHarianRepositoryImplement extends Eloquent implements RekapPresensiHarianRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(RekapPresensiHarian $model)
    {
        $this->model = $model;
    }

    // Write something awesome :)
}
