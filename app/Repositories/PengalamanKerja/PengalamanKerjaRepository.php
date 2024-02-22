<?php

namespace App\Repositories\PengalamanKerja;

use LaravelEasyRepository\Repository;

interface PengalamanKerjaRepository extends Repository{

    // Write something awesome :)
    function list();
    function store();
    function delete($riwayatPmk);
    function getMessage();
}
