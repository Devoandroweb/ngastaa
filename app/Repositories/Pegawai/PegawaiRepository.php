<?php

namespace App\Repositories\Pegawai;

use LaravelEasyRepository\Repository;

interface PegawaiRepository extends Repository{

    // Write something awesome :)
    function allPegawaiWithRole($kodeSkpd = null, $forApi = false);
    function getFirstPegawai($nip);
    function getAllPegawai();
    function updatoOrCreatoToTotalPresensi();
}
