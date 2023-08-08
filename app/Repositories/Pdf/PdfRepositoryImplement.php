<?php

namespace App\Repositories\Pdf;

use LaravelEasyRepository\Implementations\Eloquent;
// use App\Models\Pdf;
use PDF;
class PdfRepositoryImplement extends Eloquent implements PdfRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */


    public function __construct()
    {

    }
    function generatePresesiSebulan($bulan, $xl, $tahun, $pegawai,$jamKerja){
        return PDF::loadView('laporan.presensi.pegawai', compact('bulan', 'xl', 'tahun', 'pegawai','jamKerja'))->setPaper('a4', 'landscape');
    }
    // Write something awesome :)
}
