<?php

namespace App\Repositories\Pegawai;

use LaravelEasyRepository\Repository;

interface PegawaiRepository extends Repository{

    // Write something awesome :)
    function getAllPegawaiRoleOPD($role);
    function getOnePegawaiRoleOPD($role,$nip);
    function getWhereNotInPegawaiRoleOPD($role,$nip);
    function getAllPegawai();
    function updatoOrCreatoToTotalPresensi();
}
