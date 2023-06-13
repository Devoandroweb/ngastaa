<?php

namespace App\Repositories\Pegawai;

use LaravelEasyRepository\Repository;

interface PegawaiRepository extends Repository{

    // Write something awesome :)
    function allPegawaiWithRole($levelJabatanUser = null, $kodeSkpd = null);
    function getAllPegawai();
    function updatoOrCreatoToTotalPresensi();
}
