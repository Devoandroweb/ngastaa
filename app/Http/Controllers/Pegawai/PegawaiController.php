<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\PegawaiResource;
use App\Http\Resources\Select\SelectResource;
use App\Imports\ImportPegawaiExcell;
use App\Models\Master\Skpd;
use App\Models\Pegawai\Imei;
use App\Models\Presensi\TotalPresensi;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use Maatwebsite\Excel\Facades\Excel;


class PegawaiController extends Controller
{
    public function index()
    {
        $skpd = Skpd::all();
        return view('pages/pegawai/pegawai/index',compact('skpd'));
    }

    public function json()
    {
        $q = request('q');
        $pegawai = User::role('pegawai')->orderBy('name')->get();
        SelectResource::withoutWrapping();
        $pegawai = SelectResource::collection($pegawai);

        return response()->json($pegawai);
    }

    public function json_skpd()
    {
        $skpd = request()->query('skpd');

        $pegawai = User::role('pegawai')
            ->select('users.name', 'users.nip')
            ->leftJoin('riwayat_jabatan', 'riwayat_jabatan.nip', 'users.nip')
            ->leftJoin('tingkat', 'tingkat.kode_tingkat', 'riwayat_jabatan.kode_tingkat')
            ->where('riwayat_jabatan.is_akhir', 1)
            ->where('tingkat.kode_skpd', $skpd)
            ->orderBy('name')
            ->get();
        SelectResource::withoutWrapping();
        $pegawai = SelectResource::collection($pegawai);

        return response()->json($pegawai);
    }

    public function add()
    {
        $pegawai = new User();

        // return inertia('Pegawai/Pegawai/Add', compact('pegawai'));
        return view('pages/pegawai/pegawai/add');
    }

    public function edit(User $pegawai)
    {
        // return inertia('Pegawai/Pegawai/Add', compact('pegawai'));
        return view('pages/pegawai/pegawai/edit', compact('pegawai'));
    }

    public function detail(User $pegawai)
    {
        $pegawai->tlahir = tanggal_indo($pegawai->tanggal_lahir);
        // dd($pegawai);

        return view('pages/pegawai/pegawai/detail', compact('pegawai'));
        // return inertia('Pegawai/Pegawai/detail', compact('pegawai'));
    }
    public function detailPribadi(User $pegawai)
    {
        $pegawai->tlahir = tanggal_indo($pegawai->tanggal_lahir);
        // dd($pegawai);
        $view = view("pages.pegawai.pegawai.datautama.pribadi",compact("pegawai"))->render();
        return response()->json(["view"=>$view]);
        // return view('Pages/Pegawai/Pegawai/detail', compact('pegawai'));
        // return inertia('Pegawai/Pegawai/detail', compact('pegawai'));
    }


    public function delete(User $pegawai)
    {
        $cr = $pegawai->delete();
        if ($cr) {
            return redirect(route('pegawai.pegawai.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('pegawai.pegawai.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function store()
    {
        $rules = [
            'nip' => 'required',
            'nik' => 'required',
            'name' => 'required',
            'gelar_depan' => 'nullable',
            'gelar_belakang' => 'nullable',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'kode_status' => 'required',
            'jenis_kelamin' => 'required',
            'no_hp' => 'required',
            'kode_agama' => 'nullable',
            'kode_kawin' => 'nullable',
            'golongan_darah' => 'nullable',
            'email' => 'nullable',
            'alamat' => 'nullable',
            'alamat_ktp' => 'nullable',
            'image' => 'nullable',
        ];

        if (!request('id')) {
            $rules['nik'] = 'required|unique:users';
            $rules['nip'] = 'required|unique:users';
        }
        $data = request()->validate($rules);
        // dd($data);
        $data['tanggal_lahir'] = date("Y-m-d",strtotime(str_replace("/","-",$data['tanggal_lahir'])));
        $dir = "data_pegawai/".$data['nip']."/foto";
        if(request()->hasFile('image')){
            $image =  uploadImage($dir,request()->file('image'));
            $data['image'] = $dir.'/'.$image;
        }
        if (!request('id')) {

            $data['password'] = Hash::make(request('nip'));
            $cr = User::create($data);
            TotalPresensi::firstOrCreate([
                'nip' => request('nip'),
                'periode_bulan' =>  date("Y-m")
            ]);
            $cr->assignRole('pegawai');
        } else {
            $user =  User::where('nip', request('nip'));
            if(request()->hasFile('image')){
                @unlink($user->first()->image);
            }
            $cr = $user->update($data);
        }

        if ($cr) {
            return redirect(route('pegawai.pegawai.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil!"
            ]);
        } else {
            return redirect(route('pegawai.pegawai.index'))->with([
                'type' => 'error',
                'messages' => "Gagal!"
            ]);
        }
    }

    public function upload()
    {
        request()->validate([
            'file' => 'max:2048|mimes:jpg,jpeg,png',
        ]);

        $nip = request('nip');
        $cek = User::where('nip', $nip)->first();
        if (request()->file('file') && $cek) {
            if ($cek->image) {
                Storage::delete($cek->image);
            }
            // $ext = request()->file('file')->getClientOriginalExtension();
            $file =  uploadImage("data_pegawai/".$nip."/foto",request()->file('file'));
            $cr = $cek->update(['image' => $file]);
            if ($file != "" && $cr) {
                return response()->json(['status' => TRUE, 'file' => $file]);
            } else {
                return response()->json(['status' => FALSE]);
            }
        } else {
            return response()->json(['status' => FALSE]);
        }
    }
    function shift(User $pegawai){
        $Rshift = null;
        $for = 1;
        $front = "&front=1";
        return view('pages.pegawai.pegawai.add-shift',compact('for','Rshift','pegawai','front'));

    }
    public function datatable(DataTables $dataTables)
    {
        $role = role('opd') || role('buk');
        $filterSkpd = request()->query('kode_skpd');
        // dd($role);
        $pegawai = User::role('pegawai')
            ->when($role, function ($qr) {
                $user = auth()->user()->jabatan_akhir;

                $jabatan = array_key_exists('0', $user->toArray()) ? $user[0] : null;
                $skpd = '';
                if ($jabatan) {
                    $skpd = $jabatan->kode_skpd;
                }
                // dd($skpd);
                $qr->join('riwayat_jabatan', function ($qt) use ($skpd) {
                    $qt->on('riwayat_jabatan.nip', 'users.nip')
                        ->where('kode_skpd', $skpd)
                        ->where('is_akhir', 1);
                });
            });
        if($filterSkpd){
            $pegawai->join('riwayat_jabatan', function ($qt) use ($filterSkpd) {
                $qt->on('riwayat_jabatan.nip', 'users.nip')
                    ->where('kode_skpd', $filterSkpd)
                    ->where('is_akhir', 1);
            });
        }
        return $dataTables->of($pegawai)
            ->addColumn('images', function ($row) {
                return '<div>
                        <div class="avatar avatar-xs avatar-rounded d-md-inline-block d-none">
                        <img src="' . $row->foto() . '" alt="user" class="avatar-img">
                    </div>';
            })
            ->addColumn('nama', function ($row) {
                return '<b class="text-primary">' . $row->nip . '</b><br>' .  ($row->gelar_depan ? $row->gelar_depan .". " : "") . $row->name . ($row->gelar_belakang ? ", " . $row->gelar_belakang : "");

            })
            ->addColumn('nama_jabatan', function ($row) {
                $jabatan = array_key_exists('0', $row->jabatan_akhir->toArray()) ? $row->jabatan_akhir[0] : null;
                if( $jabatan != null){
                    $skpd = $jabatan?->skpd?->nama;
                    return '<p>' . ((is_null($jabatan->tingkat?->nama)) ? "-" : $jabatan->tingkat?->nama) . '</p><p>' . $skpd . '</p>';
                }
                return "-";
            })
            ->addColumn('level', function ($row) {
                $jabatan = array_key_exists('0', $row->jabatan_akhir->toArray()) ? $row->jabatan_akhir[0] : null;
                // dd($jabatan->tingkat?->eselon?->nama);
                if($jabatan){
                    return '<p>' . $jabatan?->tingkat?->eselon?->nama ?? "-". '</p>';
                }
                return "-";
            })
            ->addColumn('no_hp', function ($row) {
                return '<p class="text-success">' . $row->no_hp . '</p><i>' . $row->email . '</i>';
            })
            ->addColumn('cuti', function ($row) {
                return "<span class='badge badge-danger'>{$row->maks_cuti}</span>";
            })
            ->addColumn('detail', function ($row) {
                return route('pegawai.pegawai.detail', $row->nip);
            })
            ->addColumn('opsi', function ($row) {
                $html = "-";
                $html = "<a class='me-2 edit' tooltip='Ubah' href='" . route('pegawai.pegawai.edit', $row->nip) . "'>" . icons('pencil') . "</a>";
                if(role('admin') || role('owner')){
                    // $html = "<a tooltip='detail' class='me-2 text-info' href='" . route('pegawai.pegawai.detail', $row->nip) . "'>" . icons('arror-circle-right') . "</a>";
                    $html .= "<a class='me-2 delete text-danger' tooltip='Hapus' href='" . route('pegawai.pegawai.delete', $row->nip) . "'>" . icons('trash') . "</a>";
                    $html .= "<a class='me-2 shift text-warning' tooltip='Ubah Shift' href='" . route('pegawai.pegawai.shift', $row) . "'>" . icons('refresh') . "</a>";
                }
                return $html;
            })
            ->rawColumns(['opsi', 'images', 'nama', 'nama_jabatan', 'no_hp', 'level','cuti'])
            ->addIndexColumn()
            ->toJson();
    }
    public function import_add()
    {
        return view('pages.pegawai.pegawai.import');
    }

    public function import_pegawai()
    {
        request()->validate([
            'file' => 'required|mimes:xlsx',
        ]);
        $import = new ImportPegawaiExcell;
        Excel::import($import, request()->file('file')->store('file'));
        if($import->errorStatus()){
            return to_route('pegawai.pegawai.import_add')->with([
                'type' => 'error',
                'messages' => $import->errorMessage()
            ]);
        }
        return to_route('pegawai.pegawai.index')->with([
            'type' => 'success',
            'messages' => "Berhasil meng-import pegawai"
        ]);
    }
    public function aksesAkun(User $pegawai)
    {
        $view = view("pages.pegawai.pegawai.datautama.akses-akun",compact("pegawai"))->render();
        return response()->json(["view"=>$view]);
    }
    function donwloadTemplate(){
        $filename = "template-import-pegawai.xlsx";
        $response = Response::download(public_path($filename), $filename, [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'inline; filename="' . $filename . '"'
        ]);
        ob_end_clean();
        return $response;
    }
    function resetDevice($nip){
        try {
            Imei::where('nip',$nip)->delete();
            return response()->json(['status' => TRUE,'message'=>'Device ID berhasil di reset']);
        } catch (\Throwable $th) {
            return response()->json(['status' => FALSE, 'message'=>"Error Server"]);
            //throw $th;
        }
    }
    function resetPassword($nip){
        try {
            // dd($nip);
            User::where('nip',$nip)->first()->update([
                "password" => Hash::make($nip)
            ]);
            // dd($status);
            return response()->json(['status' => TRUE, 'message'=>'Password berhasil di reset, gunakan password NIP']);
        } catch (\Throwable $th) {
            return response()->json(['status' => FALSE, 'message'=>"Error Server"]);
            //throw $th;
        }
    }
}
