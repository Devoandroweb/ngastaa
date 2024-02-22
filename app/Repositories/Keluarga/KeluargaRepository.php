<?php

namespace App\Repositories\Keluarga;

use App\Models\User;
use LaravelEasyRepository\Repository;

interface KeluargaRepository extends Repository{
    function semuaKeluargaList();
    function orangTuaList();
    function anakList();
    function pasanganList();
    function store();
    function delete($keluarga);
    function checkKeluarga($status);
    function getMessage();
}
