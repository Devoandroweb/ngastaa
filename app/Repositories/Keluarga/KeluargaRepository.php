<?php

namespace App\Repositories\Keluarga;

use App\Models\User;
use LaravelEasyRepository\Repository;

interface KeluargaRepository extends Repository{
    function semuaKeluargaList($nip);
    function orangTuaList($nip);
    function anakList($nip);
    function pasanganList($nip);
    function store(User $pegawai);
}
