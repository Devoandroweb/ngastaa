<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\Controller;
use App\Models\Payroll\DaftarBonusPayroll;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DaftarBonusPayrollController extends Controller
{
    public function index()
    {
        return view('pages/payroll/daftarbonus/index');
    }

    public function add()
    {
        $bonus = new DaftarBonusPayroll();
        return view('pages/payroll/daftarbonus/add',compact('bonus'));
    }

    public function edit(DaftarBonusPayroll $bonus)
    {
        return view('pages/payroll/daftarbonus/edit', compact('bonus'));
    }

    public function delete(DaftarBonusPayroll $bonus)
    {
        $cr = $bonus->delete();
        if ($cr) {
            return redirect(route('payroll.bonus.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('payroll.bonus.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store()
    {
        $rules = [
            'kode_bonus' => 'required',
            'bulan' => 'nullable',
            'tahun' => 'nullable',
            'is_periode' => 'required',
            'keterangan' => 'required',
            'kode_keterangan' => 'nullable',
        ];

        $data = request()->validate($rules);

        if (request('is_periode') == 1) {
            if (request('bulan') == null) {
                $data['bulan'] = date('m');
            }
            if (request('tahun') == null) {
                $data['tahun'] = date('Y');
            }
        }

        $kode = [];
        if (request('keterangan') == 1) {
            foreach (request('kode_keterangan') as $k) {
                array_push($kode, trim(json_decode($k)->nip));
            }

            $data['kode_keterangan'] = implode(',', $kode);
        }
        if (request('keterangan') == 2) {
            $data['kode_keterangan'] = json_decode($data['kode_keterangan'])->kode_tingkat;
        }
        if (request('keterangan') == 3) {
            $data['kode_keterangan'] = json_decode($data['kode_keterangan'])->kode_eselon;
        }
        if (request('keterangan') == 4) {
            $data['kode_keterangan'] = json_decode($data['kode_keterangan'])->kode_skpd;
        }
        if (request('keterangan') == 'semua') {
            $data['kode_keterangan'] = "";
        }

        $id = request('id');

        $cr = DaftarBonusPayroll::updateOrCreate(
            [
                'id' => $id,
            ],
            $data
        );

        if ($cr) {
            return redirect(route('payroll.bonus.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, diperbaharui!"
            ]);
        } else {
            return redirect(route('payroll.bonus.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, diperbaharui!"
            ]);
        }
    }
    public function datatable(DataTables $dataTables)
    {
        $bonus = DaftarBonusPayroll::get();
        return $dataTables->of($bonus)
            ->addColumn('detail', function ($row) {
                return detail_keterangan($row->keterangan, $row->kode_keterangan);
            })
            ->addColumn('keterangan', function ($row) {
                return keterangan($row->keterangan);
            })
            ->addColumn('tanggal', function ($row) {
                return $row->is_periode == 1 ? bulan($row->bulan) . " / " . $row->tahun : "Selamanya";
            })
            ->addColumn('nama', function ($row) {
                return $row->tambah?->nama;
            })
            ->addColumn('nilai', function ($row) {
                return $row->tambah?->nilai;
            })
            ->addColumn('opsi', function ($row) {

                $html = "<a class='me-2 edit' tooltip='Edit' href='" . route('payroll.bonus.edit', $row->id) . "'>" . icons('pencil') . "</a>";
                $html .= "<a class='text-danger delete' tooltip='Hapus' href='" . route('payroll.bonus.delete', $row->id) . "'>" . icons('trash') . "</a>";
                return $html;
            })
            ->rawColumns(['opsi'])
            ->addIndexColumn()->toJson();
    }
}
