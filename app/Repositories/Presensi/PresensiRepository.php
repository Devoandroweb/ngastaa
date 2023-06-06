<?php

namespace App\Repositories\Presensi;

use LaravelEasyRepository\Repository;

interface PresensiRepository extends Repository{

    // Write something awesome :)
    function presensiDay($nip);
}
