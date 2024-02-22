<?php

namespace App\Repositories\Pendidikan;

use LaravelEasyRepository\Repository;

interface PendidikanRepository extends Repository{

    // Write something awesome :)
    public function list();
    public function listTingkatPendidikan();
    function listJurusanPendidikan($kode_pendidikan);
    public function delete($riwayatPendidikan);
    public function store();
    public function getMessage();
}
