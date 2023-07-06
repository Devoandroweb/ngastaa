<?php

namespace App\Http\Controllers\Payroll;

use App\Exports\ExportTemplateGaji;
use App\Http\Controllers\Controller;
use App\Imports\ImportGaji;
use App\Models\Payroll\PayrollKurang;
use App\Repositories\Payroll\PayrollRepository;
use App\Repositories\Pegawai\PegawaiRepository;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CustomPayrollController extends Controller
{
    protected $pegawaiRepository;
    protected $payrollRepository;
    function __construct(
        PegawaiRepository $pegawaiRepository,
        PayrollRepository $payrollRepository
        ){
        $this->pegawaiRepository = $pegawaiRepository;
        $this->payrollRepository = $payrollRepository;
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

        $response = Excel::import(new ImportGaji($this->payrollRepository),request()->file('file'));

    }
}
