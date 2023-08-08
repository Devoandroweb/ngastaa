<?php

namespace App\Repositories\JamKerja;

use LaravelEasyRepository\Repository;

interface JamKerjaRepository extends Repository{

    // Write something awesome :)
    function getJamKerjaWhere($where);
    function searchHariJamKerja($kodeJamKerja,$hari);
}
