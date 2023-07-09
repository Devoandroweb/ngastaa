<?php

namespace App\Http\Controllers;

use App\Models\Master\Tingkat;
use App\Models\MMenu;
use App\Models\MRoleMenu;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class RoleMenuController extends Controller
{
    function index(){
        return view('pages.setting.role_management.index');
    }
    function manage(Tingkat $tingkat){
        $menus = MMenu::all();
        $roleMenu = MRoleMenu::where('kode_tingkat',$tingkat->kode_tingkat)->get();
        return view('pages.setting.role_management.manage-role',compact('tingkat','menus','roleMenu'));
    }
    function manageSave(){
        // dd(request()->all());
        MRoleMenu::where('kode_tingkat',request('kode_tingkat'))->delete();
        $data = [];
        foreach (request('kode_menu') as $key => $value) {
            $data[] = [
                'kode_tingkat' => request('kode_tingkat'),
                'kode_menu' => $value,
                'has_permission' => implode(",",request('sub_menu')[$value])
            ];
        }
        MRoleMenu::insert($data);
        return to_route('setting.role-menu.index')->with([
            'type' => 'success',
            'messages' => 'Berhasil Update Role!'
        ]);

    }
    function datatable(DataTables $dataTables){
        $tingkat = Tingkat::with('roleMenu');
        return $dataTables->of($tingkat)
        ->addColumn('nama_skpd', function ($row) {
            return $row->skpd?->nama ?? "-";
        })
        ->addColumn('opsi', function ($row) {
            $html = "-";
            $html = "<a class='me-2 edit' tooltip='Manage Role Menu' href='" . route('setting.role-menu.manage', $row->id) . "'>" . icons('cogs') . "</a>";
            $html .= "<a class='me-2 delete text-danger' tooltip='Hapus' href='" . route('pegawai.pegawai.delete', $row->id) . "'>" . icons('trash') . "</a>";
            return $html;
        })
        ->rawColumns(['opsi'])
        ->addIndexColumn()
        ->toJson();
    }
}
