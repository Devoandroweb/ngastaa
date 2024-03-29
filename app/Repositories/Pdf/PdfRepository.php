<?php

namespace App\Repositories\Pdf;

use LaravelEasyRepository\Repository;

interface PdfRepository extends Repository{

    // Write something awesome :)
    function generatePresesiSebulan($bulan, $xl, $tahun, $pegawai,$jamKerja,$mJamKerja);
}
