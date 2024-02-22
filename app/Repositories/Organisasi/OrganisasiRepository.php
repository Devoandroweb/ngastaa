<?php

namespace App\Repositories\Organisasi;

use LaravelEasyRepository\Repository;

interface OrganisasiRepository extends Repository{

    // Write something awesome :)
    function list();
    function store();
    function delete($riwayatOrganisasi);
    function getMessage();
}
