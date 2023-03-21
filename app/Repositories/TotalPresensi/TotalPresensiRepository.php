<?php

namespace App\Repositories\TotalPresensi;

use LaravelEasyRepository\Repository;

interface TotalPresensiRepository extends Repository{

    // Write something awesome :)
    public function calculatePresensi($role);
}
