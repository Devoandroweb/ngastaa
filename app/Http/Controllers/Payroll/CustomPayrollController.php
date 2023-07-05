<?php

namespace App\Http\Controllers\Payroll;

use App\Exports\ExportTemplateGaji;
use App\Http\Controllers\Controller;
use App\Imports\ImportGaji;
use App\Models\Payroll\PayrollKurang;
use App\Repositories\Pegawai\PegawaiRepository;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CustomPayrollController extends Controller
{
    protected $pegawaiRepository;
    function __construct(PegawaiRepository $pegawaiRepository){
        $this->pegawaiRepository = $pegawaiRepository;
    }
    function index() {
        return view('pages.payroll.generate.import');
    }
    function templatePayrollImport() {
        $filename = "template-import-gaji-new.xlsx";
        $response = Excel::download(new ExportTemplateGaji($this->pegawaiRepository), $filename);
        ob_end_clean();
        return $response;
    }
    function importGaji() {
        // dd(request()->file('file'));
        
        $response = Excel::import(new ImportGaji(),request()->file('file'));

    }
}
