<?php

namespace App\Http\Controllers\Pegawai;

use App\Exports\ExportDataPegawai;
use App\Exports\ExportDataPegawaiWithDivision;
use App\Exports\ExportSampleImportPegawai;
use App\Http\Controllers\Controller;
use App\Http\Resources\Select\SelectResource;
use App\Imports\ImportPegawaiExcell;
use App\Imports\ImportTemplateProtection;
use App\Models\MapLokasiKerja;
use App\Models\Master\Eselon;
use App\Models\Master\Jabatan;
use App\Models\Master\Lokasi;
use App\Models\Master\Skpd;
use App\Models\Master\StatusPegawai;
use App\Models\Master\Tingkat;
use App\Models\MJadwalShift;
use App\Models\Payroll\DataPayroll;
use App\Models\Payroll\PayrollKurang;
use App\Models\Payroll\PayrollTambah;
use App\Models\Pegawai\DataPengajuanCuti;
use App\Models\Pegawai\DataPengajuanLembur;
use App\Models\Pegawai\DataPengajuanReimbursement;
use App\Models\Pegawai\DataPresensi;
use App\Models\Pegawai\DataVisit;
use App\Models\Pegawai\Imei;
use App\Models\Pegawai\Keluarga;
use App\Models\Pegawai\RiwayatBahasa;
use App\Models\Pegawai\RiwayatCuti;
use App\Models\Pegawai\RiwayatJabatan;
use App\Models\Pegawai\RiwayatJamKerja;
use App\Models\Pegawai\RiwayatKgb;
use App\Models\Pegawai\RiwayatKursus;
use App\Models\Pegawai\RiwayatLainnya;
use App\Models\Pegawai\RiwayatLhkpn;
use App\Models\Pegawai\RiwayatOrganisasi;
use App\Models\Pegawai\RiwayatPendidikan;
use App\Models\Pegawai\RiwayatPmk;
use App\Models\Pegawai\RiwayatPotongan;
use App\Models\Pegawai\RiwayatShift;
use App\Models\Pegawai\RiwayatSpt;
use App\Models\Pegawai\RiwayatStatus;
use App\Models\Pegawai\RiwayatTunjangan;
use App\Models\Presensi\TotalPresensi;
use App\Models\Presensi\TotalPresensiDetail;
use App\Models\User;
use App\Repositories\Pegawai\PegawaiRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;


class PegawaiController extends Controller
{
    protected $pegawaiRepository;
    // protected $pegawaiWithRole;
    function __construct(
        PegawaiRepository $pegawaiRepository
    ){
        $this->pegawaiRepository = $pegawaiRepository;
    }
    public function index()
    {

        $skpd = Skpd::all();
        $lokasiKerja = Lokasi::orderBy('nama','asc')->get();
        $statusPegawai = StatusPegawai::orderBy('nama','asc')->get();

        $levelJabatan = Eselon::withFilterUserEselon()->orderBy('nama')->get();
        $tingkatJabatan = Tingkat::withFilterUserEselon()->selectRaw("nama,kode_eselon, GROUP_CONCAT(kode_tingkat SEPARATOR ',') AS kode_tingkat")
        ->groupBy('nama','kode_eselon')
        ->get();
        return view('pages/pegawai/pegawai/index',compact('skpd','lokasiKerja','statusPegawai','levelJabatan','tingkatJabatan'));
    }

    public function json()
    {
        $q = request('q');
        $kodeSkpd = request()->query('kode_skpd');
        // dd($kodeSkpd);
        $pegawai = $this->pegawaiRepository->allPegawaiWithRole($kodeSkpd)->get();
        SelectResource::withoutWrapping();
        $pegawai = SelectResource::collection($pegawai);
        return response()->json($pegawai);
    }

    public function json_skpd()
    {
        $kodeSkpd = request()->query('skpd');
        $pegawai = $this->pegawaiRepository->allPegawaiWithRole($kodeSkpd)->get();
        SelectResource::withoutWrapping();
        $pegawai = SelectResource::collection($pegawai);

        return response()->json($pegawai);
    }

    public function add()
    {
        $skpd = Skpd::all(); # Divisi
        $jabatan = Tingkat::all(); # Jabatan

        // return inertia('Pegawai/Pegawai/Add', compact('pegawai'));
        return view('pages/pegawai/pegawai/add',compact('skpd','jabatan'));
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
        RiwayatJabatan::where('nip',$pegawai->nip)->delete();
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
        // dd(request()->all());
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
            if (role('admin') || role('owner')) {
                $rules['kode_skpd'] = 'required';
                $rules['kode_tingkat'] = 'required';
            }
        }
        $data = request()->validate($rules);
        // dd($data);
        $nip = $data['nip'];

        // dd($data);
        $data['tanggal_lahir'] = date("Y-m-d",strtotime(str_replace("/","-",$data['tanggal_lahir'])));
        $dir = "data_pegawai/".$nip."/foto";
        if(request()->hasFile('image')){
            $image =  uploadImage($dir,request()->file('image'));
            $data['image'] = $dir.'/'.$image;
        }
        // dd(!request('id'));
        if (!request('id')) {
            // dd($data);
            $data['password'] = Hash::make($nip);
            $dataInsert = collect($data);

            if(!role('owner') && !role('admin')){
                $kodeSkpd = getKodeSkpdUser();
                $eselon = Eselon::where('kode_eselon',6)->first();
                if($eselon == null){
                    return redirect()->back()->with([
                        'type' => 'error',
                        'messages' => "Level Jabatan 'Pegawai' tidak di temukan, Hubungi Administrator"
                    ]);
                }
                $tingkat = Tingkat::where('kode_eselon',6)->where('kode_skpd',$kodeSkpd)->first();
                if($tingkat == null){
                    return redirect()->back()->with([
                        'type' => 'error',
                        'messages' => "Tingkat Jabatan 'Pegawai' tidak di temukan, Hubungi Administrator"
                    ]);
                }
                RiwayatJabatan::create([
                    'nip' => $nip,
                    'kode_tingkat' => $tingkat?->kode_tingkat,
                    'kode_skpd' => getKodeSkpdUser(),
                    'is_akhir' => 1,
                    'jenis_jabatan' => 1
                ]);
            }else{
                # Add Jabatan
                RiwayatJabatan::create([
                    'nip' => $nip,
                    'kode_tingkat' => $data['kode_tingkat'],
                    'kode_skpd' => $data['kode_skpd'],
                    'is_akhir' => 1,
                    'jenis_jabatan' => 1
                ]);
            }

            $cr = User::create($dataInsert->forget(['kode_skpd','kode_tingkat'])->toArray());
            TotalPresensi::firstOrCreate([
                'nip' => $nip,
                'periode_bulan' =>  date("Y-m")
            ]);
            $cr->assignRole('pegawai');
        } else {
            $user =  User::find(request('id'));
            if(request()->hasFile('image')){
                @unlink($user->first()->image);
            }
            $this->updateNip($user->nip,$nip);
            $cr = $user->update($data);
            // dd($cr,$data);

            // $cr->assignRole('pegawai');

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
    function updateKontrak(){
        try {
            $nips = request('list-pegawai');
            // $dateStart = date("Y-m-d");
            $dateEnd = date("Y-m-d",request('date_kontrak'));
            foreach ($nips as $nip) {
                $pegawai = $this->pegawaiRepository->getFirstPegawai($nip);
                # cari jabatan
                $jabatan = $pegawai->jabatan_akhir()->first();
                # update kontrak jabatan pada riwayat jabatan
                $jabatan->update([
                    'tanggal_tmt' => $dateEnd
                ]);
            }
            return response()->json([
                'status' => TRUE,
                'message' => 'Berhasil Update Kontrak'
            ],200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => FALSE,
                'message' => 'Gagal Update Kontrak',
                'error' => $th->getMessage()
            ],500);
        }


    }
    public function datatable(DataTables $dataTables)
    {

        // dd($kodeSkpd);
        $kodeSkpd = request()->query('kode_skpd');
        $kodeLokasi = request()->query('kode_lokasi');
        $namaPegawai = request()->query('nama_pegawai');
        $statusPegawai = request()->query('status_pegawai');
        $kodeEselon = request()->query('kode_eselon');
        $kodeTingkat = request()->query('kode_tingkat');
        $nip = request()->query('nip_pegawai');
        $nip = explode(",",$nip);
        Session::put('current_select_kode_eselon',$kodeEselon);
        Session::put('current_select_kode_tingkat',$kodeTingkat);
        Session::put('current_select_skpd',$kodeSkpd);
        Session::put('current_select_lokasi',$kodeLokasi);
        Session::put('current_select_status_pegawai',$statusPegawai);
        // dd($kodeSkpd);
        $pegawai = $this->pegawaiRepository->allPegawaiWithRole($kodeSkpd);
        if($namaPegawai){
            $pegawai = $pegawai->where('name','like','%'.$namaPegawai.'%');
        }

        if(count($nip) > 0 && $nip[0] != ""){
            $pegawai = $pegawai->whereIn('users.nip',$nip);
        }
        // dd($statusPegawai);
        if($statusPegawai != 0){
            $pegawai = $pegawai->where('kode_status',$statusPegawai);
        }
        $pegawai = $pegawai->orderBy('users.created_at','desc')->get(['users.*','users.id as id_user']);
        if($kodeTingkat!=0){
            $pegawai = $pegawai->filter(function($row)use($kodeTingkat){
                $kodeTingkat = explode(",",$kodeTingkat);
                if(in_array($row->jabatan_akhir()->first()->kode_tingkat,$kodeTingkat)){
                    return $row;
                }
            });
        }
        if($kodeEselon!="null"&&$kodeEselon!=0){
            $pegawai = $pegawai->filter(function($row)use($kodeEselon){
                if($row->jabatan_akhir()->first()?->tingkat?->kode_eselon==$kodeEselon){
                    return $row;
                }
            });
        }

        return $dataTables->of($pegawai)
            ->addColumn('checkbox', function ($row) {
                return '<input type="checkbox" name="nip[]" value="'.$row->nip.'" class="form-check-input checkbox-nip">';
            })
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
                $jabatan = $row->jabatan_akhir()->first();
                return '<p>'.$jabatan?->skpd?->nama.'</p><p>'.$jabatan?->tingkat?->nama.'</p>';
            })
            // ->addColumn('level', function ($row) {
            //     $jabatan = array_key_exists('0', $row->jabatan_akhir->toArray()) ? $row->jabatan_akhir[0] : null;
            //     // dd($jabatan->tingkat?->eselon?->nama);
            //     if($jabatan){
            //         return '<p>' . $jabatan?->tingkat?->eselon?->nama ?? "-". '</p>';
            //     }
            //     return "-";
            // })
            // ->addColumn('no_hp', function ($row) {
            //     return '<p class="text-success">' . $row->no_hp . '</p><i>' . $row->email . '</i>';
            // })
            ->addColumn('kode_status', function ($row) {
                return buildBadge("info",$row->kode_status);
            })
            // ->addColumn('cuti', function ($row) {
            //     return "<span class='badge badge-danger'>{$row->maks_cuti}</span>";
            // })
            ->addColumn('lokasi_kerja', function ($row) {
                return $row->lokasiKerja?->lokasiKerja?->nama ?? "-";
            })
            ->addColumn('jam_kerja', function ($row) {
                return $row->jamKerja->where('is_akhir',1)->first()?->jamKerja?->nama ?? "-";
            })
            ->addColumn('detail', function ($row) {
                return route('pegawai.pegawai.detail', $row->nip);
            })
            ->addColumn('opsi', function ($row) {
                $html = "-";
                if(getPermission('pegawai','U') || role('admin') || role('owner')){

                    $html = "<a class='me-2 edit' tooltip='Ubah' href='" . route('pegawai.pegawai.edit', $row->nip) . "'>" . icons('pencil') . "</a>";
                }
                if(getPermission('pegawai','D') || role('admin') || role('owner')){
                    // $html = "<a tooltip='detail' class='me-2 text-info' href='" . route('pegawai.pegawai.detail', $row->nip) . "'>" . icons('arror-circle-right') . "</a>";
                    $html .= "<a class='me-2 delete text-danger' tooltip='Hapus' href='" . route('pegawai.pegawai.delete', $row->nip) . "'>" . icons('trash') . "</a>";
                }
                if(getPermission('pegawai','US') || role('admin') || role('owner')){
                    $html .= "<a class='me-2 shift text-warning' tooltip='Ubah Shift' href='" . route('pegawai.pegawai.shift', $row) . "'>" . icons('refresh') . "</a>";
                }
                return $html;
            })
            ->rawColumns(['opsi', 'images', 'nama', 'nama_jabatan', 'kode_status', 'level','cuti','checkbox'])
            ->addIndexColumn()
            ->toJson();
    }
    public function datatable1(DataTables $dataTables)
    {
        // dd($kodeSkpd);
        $kodeSkpd = request()->query('kode_skpd');
        $kodeLokasi = request()->query('kode_lokasi');
        $namaPegawai = request()->query('nama_pegawai');
        $statusPegawai = request()->query('status_pegawai');
        $nip = request()->query('nip_pegawai');
        $nip = explode(",",$nip);
        Session::put('current_select_skpd',['pegawai'=>$kodeSkpd]);
        Session::put('current_select_lokasi',['lokasi'=>$kodeLokasi]);
        Session::put('current_select_status_pegawai',['status_pegawai'=>$statusPegawai]);
        // dd($kodeSkpd);
        $pegawai = $this->pegawaiRepository->allPegawaiWithRole($kodeSkpd);

        if($namaPegawai){
            $pegawai = $pegawai->where('nama_pegawai','like','%'.$namaPegawai.'%');
        }

        if(count($nip) > 0 && $nip[0] != ""){
            $pegawai = $pegawai->whereIn('nip',$nip);
        }
        // dd($statusPegawai);
        if($statusPegawai != 0){
            $pegawai = $pegawai->where('kode_status',$statusPegawai);
        }
        $pegawai = $pegawai->get();
        return $dataTables->of($pegawai)
            ->addColumn('checkbox', function ($row) {
                return '<input type="checkbox" name="nip[]" value="'.$row->nip.'" class="form-check-input checkbox-nip">';
            })
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

                return '<p>'.$row->nama_divisi.'</p><p>'.$row->nama_tingkat.'</p>';
            })

            ->addColumn('kode_status', function ($row) {
                return buildBadge("info",$row->kode_status);
            })
            ->addColumn('lokasi_kerja', function ($row) {
                return $row->nama_lokasi_kerja ?? "-";
            })
            ->addColumn('jam_kerja', function ($row) {
                return $row->jam_kerja ?? "-";
            })
            ->addColumn('detail', function ($row) {
                return route('pegawai.pegawai.detail', $row->nip);
            })
            ->addColumn('opsi', function ($row) {
                $html = "-";
                if(getPermission('pegawai','U') || role('admin') || role('owner')){

                    $html = "<a class='me-2 edit' tooltip='Ubah' href='" . route('pegawai.pegawai.edit', $row->nip) . "'>" . icons('pencil') . "</a>";
                }
                if(getPermission('pegawai','D') || role('admin') || role('owner')){
                    // $html = "<a tooltip='detail' class='me-2 text-info' href='" . route('pegawai.pegawai.detail', $row->nip) . "'>" . icons('arror-circle-right') . "</a>";
                    $html .= "<a class='me-2 delete text-danger' tooltip='Hapus' href='" . route('pegawai.pegawai.delete', $row->nip) . "'>" . icons('trash') . "</a>";
                }
                if(getPermission('pegawai','US') || role('admin') || role('owner')){
                    $html .= "<a class='me-2 shift text-warning' tooltip='Ubah Shift' href='" . route('pegawai.pegawai.shift', $row) . "'>" . icons('refresh') . "</a>";
                }
                return $html;
            })
            ->rawColumns(['opsi', 'images', 'nama', 'nama_jabatan', 'kode_status', 'level','cuti','checkbox'])
            ->addIndexColumn()
            ->toJson();
    }
    public function import_add()
    {
        return view('pages.pegawai.pegawai.import');
    }

    public function import_pegawai()
    {
        $rules = [
            'file' => 'required|mimes:xlsx',
        ];
        // if(role('admin') || role('owner')){
        //     $rules['kode_skpd'] = 'required';
        //     $rules['kode_tingkat'] = 'required';
        // }
        $data = request()->validate($rules);
        // if(role('admin') || role('owner')){
        //     $kodeSkpd = $data['kode_skpd'];
        //     $kodeTingkat = $data['kode_tingkat'];
        // }else{
        // }

        $kodeSkpd = getKodeSkpdUser();
        $kodeTingkat = null;
        if(request('kode_skpd')){
            $kodeSkpd = request('kode_skpd');
        }
        # Validasi Template ----------------------------------------
        try {
            //code...
            $importTemplate = new ImportTemplateProtection($kodeSkpd);
            Excel::import($importTemplate, request()->file('file')->store('file'));
            // dd($importTemplate->errorStatus());
            if($importTemplate->errorStatus()){
                return to_route('pegawai.pegawai.import_add')->with([
                    'type' => 'error',
                    'messages' => $importTemplate->message()
                ]);
            }
        } catch (\Throwable $th) {
            return to_route('pegawai.pegawai.import_add')->with([
                'type' => 'error',
                'messages' => 'Template Tidak Sesuai, Silahkan unduh ulang'
            ]);
        }
        # -----------------------------------------------------------
        // dd($importTemplate->getNumberSheet());
        $import = new ImportPegawaiExcell($kodeSkpd,$kodeTingkat,$importTemplate->getNumberSheet());
        Excel::import($import, request()->file('file')->store('file'));
        // dd($import->errorMessage(),$import->errorStatus());
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
        // dd("sadasd");
        $kodeSkpd = request()->query('kode_skpd');
        $namaSkpd = request()->query('nama_skpd');
        if($kodeSkpd){
            $filename = "import-data-pegawai-".str()->slug($namaSkpd).".xlsx";
            $response = Excel::download(new ExportSampleImportPegawai($kodeSkpd), $filename);
        }else{
            $filename = "import-data-pegawai-tanpa-divisi.xlsx";
            $response = Excel::download(new ExportSampleImportPegawai(null), $filename);
        }
        ob_end_clean();
        return $response;
        // $response = Response::download(public_path($filename), $response, [
        //         'Content-Type' => 'application/vnd.ms-excel',
        //         'Content-Disposition' => 'inline; filename="' . $response . '"'
        //     ]);
    }
    function export(){
        $datetime = date("YmdHis");
        $response = Excel::download(new ExportDataPegawaiWithDivision($this->pegawaiRepository), "data-pegawai-{$datetime}.xlsx");
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
    function updateKepegawaian(){
        // dd(request()->all());
        try {

            $nip = request('nip');
            $nip = explode(",",$nip);
            $kodeSkpd = request('kode_skpd');
            $kodeTingkat = request('kode_tingkat');
            $kodeLokasi = request('kode_lokasi');
            $statusPegawai = request('status_pegawai');
            $kodeJamKerja = request('kode_jam_kerja');
            DB::transaction(function()use($nip,$kodeTingkat,$kodeSkpd,$kodeLokasi,$kodeJamKerja,$statusPegawai){
                /* UPDATE */
                // RiwayatJabatan::whereIn("nip",$nip)->update(["is_akhir"=>0]);
                // RiwayatJamKerja::whereIn("nip",$nip)->update(["is_akhir"=>0]);
                if($statusPegawai){
                    User::whereIn("nip",$nip)->update(["kode_status"=>$statusPegawai]);
                }

                /* INSERT */

                foreach($nip as $n){
                    if($kodeSkpd){
                        $arrayRiwayatJabatan = [
                            "nip"=>$n,
                            "jenis_jabatan"=>1,
                            "kode_skpd"=>$kodeSkpd,
                            "is_akhir"=>1,
                        ];
                        RiwayatJabatan::updateOrCreate([
                            "nip"=>$n,
                            "is_akhir"=>1,
                        ],$arrayRiwayatJabatan);
                    }
                    if($kodeTingkat){
                        $arrayRiwayatJabatan = [
                            "nip"=>$n,
                            "jenis_jabatan"=>1,
                            "kode_tingkat"=>$kodeTingkat,
                            "is_akhir"=>1,
                        ];
                        RiwayatJabatan::updateOrCreate([
                            "nip"=>$n,
                            "is_akhir"=>1,
                        ],$arrayRiwayatJabatan);
                        RiwayatJabatan::where([
                            "nip"=>$n,
                            "is_akhir"=>0,
                        ])->forceDelete();
                    }
                    if($kodeJamKerja){
                        $arrayRiwayatJamKerja = [
                            "nip"=>$n,
                            "kode_jam_kerja"=>$kodeJamKerja,
                            "status"=>1,
                            "is_akhir"=>1,
                        ];
                        RiwayatJamKerja::updateOrCreate([
                            "nip"=>$n,
                            "is_akhir"=>1,
                        ],$arrayRiwayatJamKerja);
                        RiwayatJamKerja::where([
                            "nip"=>$n,
                            "is_akhir"=>0,
                        ])->forceDelete();
                    }
                    if($kodeLokasi){
                        MapLokasiKerja::where([
                            "nip"=>$n,
                        ])->forceDelete();
                        $arrayManageLokasiKerja = [
                            "nip"=>$n,
                            "kode_lokasi"=>$kodeLokasi,
                        ];
                        MapLokasiKerja::updateOrCreate([
                            "nip"=>$n
                        ],$arrayManageLokasiKerja);

                    }
                }




            });
            DB::commit();
            return response()->json(['status' => TRUE, 'message'=>'Berhasil mengubah Kepegawaian']);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            if(config('app.debug')){
                return response()->json(['status' => FALSE, 'message'=>$th->getMessage()],500);
            }
            return response()->json(['status' => FALSE, 'message'=>"Error Server"],500);
        }
    }
    function updateDivisiJabatan(){
        $user = User::where('owner',0)->get();
        foreach($user as $u){
            $jabatan = $u->jabatan_akhir()->fisrt();
            $kodeSkpd = $jabatan->kode_skpd;
        }
    }

    function updateNip($nipWhere,$nip){
        try {

            DB::transaction(function()use($nipWhere,$nip){
                $models = [
                    DataPayroll::class,
                    DataPengajuanCuti::class,
                    DataPengajuanLembur::class,
                    DataPengajuanReimbursement::class,
                    DataPresensi::class,
                    DataVisit::class,
                    Imei::class,
                    MJadwalShift::class,
                    Keluarga::class,
                    MapLokasiKerja::class,
                    PayrollKurang::class,
                    PayrollTambah::class,
                    RiwayatKgb::class,
                    RiwayatPmk::class,
                    RiwayatSpt::class,
                    RiwayatCuti::class,
                    RiwayatLhkpn::class,
                    RiwayatShift::class,
                    RiwayatBahasa::class,
                    // RiwayatDiklat::class,
                    RiwayatKursus::class,
                    RiwayatStatus::class,
                    RiwayatLhkpn::class,
                    RiwayatJabatan::class,
                    RiwayatLainnya::class,
                    // RiwayatGolongan::class,
                    RiwayatJamKerja::class,
                    RiwayatPotongan::class,
                    RiwayatTunjangan::class,
                    RiwayatOrganisasi::class,
                    RiwayatPendidikan::class,
                    TotalPresensiDetail::class,
                    MapLokasiKerja::class,
                ];
                foreach($models as $model){
                    foreach($model::where("nip",$nipWhere)->get() as $user){
                        $user->update([
                            "nip" => $nip
                        ]);
                    }
                }
            });
            # Data Payroll
            # data pengajuan cuti
            # data pengajuan lembur
            # data pengajuan reimvurs
            # data presensi
            # data visit
            # imei
            # jadwal shift
            # keluarga
            # manage lokasi kerja
            # payroll kurang
            # payroll tambah
            # semua riwayat
            # total presensi detail
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }
}
