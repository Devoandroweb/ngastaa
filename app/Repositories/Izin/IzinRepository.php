<?php

namespace App\Repositories\Izin;

use LaravelEasyRepository\Repository;

interface IzinRepository extends Repository{

    // Write something awesome :)
    public function calculateTotalIzin($nip,$periodeBulan);
    public function saveToTotalIzinDetail($izin);
}
