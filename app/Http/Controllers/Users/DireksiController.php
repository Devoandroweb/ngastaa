<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\PegawaiResource;
use App\Http\Resources\Select\SelectResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class DireksiController extends Controller
{
    public function index()
    {
        return view('pages.manageuser.direksi.index');
    }

    public function add()
    {

        $data = null;
        return view('pages.manageuser.direksi.add', compact('data'));
    }

    public function store()
    {
        $rules = [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ];
        $data = request()->validate($rules);
        $data['password'] = Hash::make(request('password'));
        $data['owner'] = 1;
        $user = User::create($data);
        $user->assignRole('owner');
        return redirect(route('users.direksi.index'))->with([
            'type' => 'success',
            'messages' => "Berhasil, Menambahkan Owner!"
        ]);
    }

    public function delete(User $direksi)
    {
        $direksi->removeRole('owner');
        return redirect()->back()->with([
            'type' => 'success',
            'messages' => 'Berhasil dihapus sebagai direksi!'
        ]);
    }
    public function datatable(DataTables $dataTables)
    {
        $users = User::role('owner')->orderBy('name')->get();
        return $dataTables->of($users)
            ->addColumn('images', function ($row) {
                return '<div>
                        <div class="avatar avatar-xs avatar-rounded d-md-inline-block d-none">
                        <img src="' . $row->foto() . '" alt="user" class="avatar-img">
                    </div>';
            })
            ->addColumn('opsi', function ($row) {
                // $html = "<a class='me-2 text-success' tooltip='Edit' href='" . route('pengajuan.cuti.approved', $row->id) . "'>" . icons('c-check', 17) . "</a>";
                $html = "<a class='me-2 delete text-danger' tooltip='Hapus' href='" . route('users.direksi.delete', ['direksi'=>$row['id']]) . "'>" . icons('trash', 17) . "</a>";
                return $html;
            })
            ->rawColumns(['opsi', 'images'])
            ->addIndexColumn()
            ->toJson();
    }
}
