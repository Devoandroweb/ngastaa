<?php

namespace App\Repositories\Payroll;

use LaravelEasyRepository\Repository;

interface PayrollRepository extends Repository{

    // Write something awesome :)
    function insertWithDivisi($kodePayroll);
    function calculatePresensi($nip);
    function hitungPayroll($pegawai,$kodePayroll,$bulan,$tahun);
    function hitungPayrollWithDivisi($kodeSkpd,$kodePayroll,$bulan,$tahun);

}
