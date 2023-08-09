<?php

namespace App\Repositories\LokasiKerja;

use LaravelEasyRepository\Repository;

interface LokasiKerjaRepository extends Repository{

    function saveManageLokasiKerja($kode_lokasi,$nips);
    function getPegawai($kode_lokasi);
}
