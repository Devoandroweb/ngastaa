<?php

namespace App\Repositories\Payroll;

use LaravelEasyRepository\Repository;

interface PayrollRepository extends Repository{

    // Write something awesome :)
    function insertWithDivisi($kodePayroll);
    function calculatePresensi($nip);
    function hitungPayroll();

}
