<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\PegawaiResource;
use App\Http\Resources\Select\SelectResource;
use App\Models\User;
use Yajra\DataTables\DataTables;

class ManagerController extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $users = User::role('opd')
            ->when($search, function ($qr, $search) {
                $qr->where('name', 'LIKE', "%$search%");
            })
            ->orderBy('name')
            ->paginate($limit);

        $users->appends(request()->all());

        $users = PegawaiResource::collection($users);
        // return inertia('Users/Manager/index', compact('users'));
        return view('pages/manageuser/kepala-divisi/index');
    }

    public function add()
    {
        $opd = User::role('opd')->pluck('id')->toArray();

        $users = User::role('pegawai')
            ->orderBy('name')
            ->whereNotIn('id', $opd)
            ->get();
        SelectResource::withoutWrapping();
        $users = SelectResource::collection($users);
        // return inertia('Users/Manager/Add', compact('users'));
        return view('pages/manageuser/kepala-divisi/add');
    }

    public function store()
    {
        $pegawai = request('pegawai');

        if (count($pegawai) > 0) {

            foreach ($pegawai as $p) {
                $user = User::where('nip', json_decode($p)->value)->first();
                $user->assignRole('opd');
            }

            return redirect(route('users.manager.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, Menambahkan Data!"
            ]);
        }

        return redirect(route('users.manager.index'))->with([
            'type' => 'error',
            'messages' => "Gagal!"
        ]);
    }

    public function delete(User $manager)
    {
        $manager->removeRole('opd');
        return redirect()->back()->with([
            'type' => 'success',
            'messages' => 'Berhasil dihapus sebagai Kepala Divisi!'
        ]);
    }
    public function datatable(DataTables $dataTables)
    {
        $users = User::role('admin')->orderBy('name')->get();
        $users = PegawaiResource::collection($users);
        return $dataTables->of($users)
            ->addColumn('images', function ($row) {
                return '<div>	
                        <div class="avatar avatar-xs avatar-rounded d-md-inline-block d-none">
                        <img src="' . asset('dist/img/businessman.png') . '" alt="user" class="avatar-img">
                        </div>';
                // <img src="' . $row['images'] . '" alt="user" class="avatar-img">
            })
            ->addColumn('nama', function ($row) {
                return '<b class="text-primary">' . $row['nip'] . '</b><br>' . $row['name'];
            })
            ->addColumn('nama_jabatan', function ($row) {
                return '<p>' . $row['nama_jabatan'] . '</p><p>' . $row['skpd'] . '</p>';
            })
            ->addColumn('no_hp', function ($row) {
                return '<p class="text-success">' . $row['no_hp'] . '</p><i>' . $row['email'] . '</i>';
            })
            ->addColumn('opsi', function ($row) {
                // $html = "<a class='me-2 text-success' tooltip='Edit' href='" . route('pengajuan.cuti.approved', $row->id) . "'>" . icons('c-check', 17) . "</a>";
                $html = "<a class='me-2 delete text-danger' tooltip='Hapus' href='" . route('users.hrd.delete', $row['nip']) . "'>" . icons('trash', 17) . "</a>";
                return $html;
            })
            ->rawColumns(['opsi', 'images', 'nama', 'nama_jabatan', 'no_hp'])
            ->addIndexColumn()
            ->toJson();
    }
}
