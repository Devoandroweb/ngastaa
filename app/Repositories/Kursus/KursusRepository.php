<?php

namespace App\Repositories\Kursus;

use LaravelEasyRepository\Repository;

interface KursusRepository extends Repository{

    // Write something awesome :)
    function list();
    function store();
    function delete($riwayatKursus);
    function listMasterKursus();
    function getMessage();
}