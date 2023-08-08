<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Payroll\DataPayrollResource;
use App\Models\Payroll\DataPayroll;
use App\Models\Payroll\PayrollKurang;
use App\Models\Payroll\PayrollTambah;
use Illuminate\Http\Request;

class PayrollApiController extends Controller
{
    public function index()
    {
        $nip = request()->query("nip");

        $payroll = DataPayroll::where('nip', $nip)->get();
        $payroll = DataPayrollResource::collection($payroll);

        return response()->json(buildResponseSukses($payroll),200);
    }
    function detail(){

        try {
            $nip = request('nip');
            $kodePayroll = request('kode_payroll');
            $where = ['nip'=>$nip,'kode_payroll'=>$kodePayroll];

            $dataPayroll = DataPayroll::where($where)->first();
            // $payrollTambah = PayrollTambah::where($where)->get();
            $payrollKurang = PayrollKurang::where($where)->get();

            $totalGaji = (int)$dataPayroll->total;

            # Pengurangan
            $listPayrollKurang = [];
            foreach ($payrollKurang as $pk) {
                $listPayrollKurang[] = [
                    'nama_potongan' => "Potongan ".$pk->keterangan,
                    'nominal' => $pk->nilai,
                ];
            }

            $data['diterima'] = $totalGaji;
            $data['detail_potongan'] = $listPayrollKurang;
            $data['kode_payroll'] = $dataPayroll->kode_payroll;
            $data['time_send'] = tanggal_indo($dataPayroll->created_at).", ".date('H:s',strtotime($dataPayroll->created_at));

            return response()->json(buildResponseSukses(['status' => TRUE, 'data' => $data]),200);
        } catch (\Throwable $th) {
            return response()->json(buildResponseGagal(['status' => FALSE, 'data' => []]),200);
            //throw $th;
        }



    }
}
