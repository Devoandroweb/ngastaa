<?php

namespace App\Repositories\Divisi;

use LaravelEasyRepository\Repository;

interface DivisiRepository extends Repository{

    // Write something awesome :)
    function allDivisionWithRole();
    function updateOrCreate($id,$data);
}
