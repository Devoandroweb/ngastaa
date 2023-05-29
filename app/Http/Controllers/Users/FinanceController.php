<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\PegawaiResource;
use App\Http\Resources\Select\SelectResource;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class FinanceController extends Controller
{
    public function index()
    {
        return view('pages/manageuser/finance/index');
    }

    public function add()
    {
        return view('pages/manageuser/finance/add');
    }

    public function store()
    {
        $pegawai = request('pegawai');

        if (count($pegawai) > 0) {

            foreach ($pegawai as $p) {
                $user = User::where('nip', json_decode($p)->value)->first();
                $user->assignRole('finance');
            }

            return redirect(route('users.finance.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, Menambahkan Data!"
            ]);
        }

        return redirect(route('users.finance.index'))->with([
            'type' => 'error',
            'messages' => "Gagal!"
        ]);
    }

    public function delete(User $finance)
    {
        $finance->removeRole('finance');
        return redirect()->back()->with([
            'type' => 'success',
            'messages' => 'Berhasil dihapus sebagai Kepala Divisi!'
        ]);
    }
    public function datatable(DataTables $dataTables)
    {
        $users = User::role('finance')->orderBy('name')->get();
        $users = PegawaiResource::collection($users);
        return $dataTables->of($users)
            ->addColumn('images', function ($row) {
                return '<div>
                        <div class="avatar avatar-xs avatar-rounded d-md-inline-block d-none">
                        <img src="' . $row->foto() . '" alt="user" class="avatar-img">
                        </div>';
                // <img src="' . $row['images'] . '" alt="user" class="avatar-img">
            })
            ->addColumn('nama', function ($row) {
                return '<b class="text-primary">' . $row['nip'] . '</b><br>' . $row['name'];
            })
            ->addColumn('nama_jabatan', function ($row) {
                $jabatan = array_key_exists('0', $row->jabatan_akhir->toArray()) ? $row->jabatan_akhir[0] : null;
                $tingkat = $jabatan?->tingkat;
                $nama_jabatan =  $tingkat?->nama;
                $skpd = $jabatan?->skpd?->nama;
                return '<p>' . $nama_jabatan . '</p><p>' . $skpd . '</p>';
            })
            ->addColumn('no_hp', function ($row) {
                return '<p class="text-success">' . $row['no_hp'] . '</p><i>' . $row['email'] . '</i>';
            })
            ->addColumn('opsi', function ($row) {
                // $html = "<a class='me-2 text-success' tooltip='Edit' href='" . route('pengajuan.cuti.approved', $row->id) . "'>" . icons('c-check', 17) . "</a>";
                $html = "<a class='me-2 delete text-danger' tooltip='Hapus' href='" . route('users.finance.delete', $row['nip']) . "'>" . icons('trash', 17) . "</a>";
                return $html;
            })
            ->rawColumns(['opsi', 'images', 'nama', 'nama_jabatan', 'no_hp'])
            ->addIndexColumn()
            ->toJson();
    }
}
