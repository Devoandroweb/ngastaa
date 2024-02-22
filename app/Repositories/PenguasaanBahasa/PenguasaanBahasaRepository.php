<?php

namespace App\Repositories\PenguasaanBahasa;

use LaravelEasyRepository\Repository;

interface PenguasaanBahasaRepository extends Repository{

    // Write something awesome :)
    public function list();
    public function store();
    public function getMessage();
    public function delete($model);
}
