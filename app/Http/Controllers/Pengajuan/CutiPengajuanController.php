<?php

namespace App\Http\Controllers\Pengajuan;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pengajuan\CutiPengajuanResource;
use App\Jobs\ProcessWaNotif;
use App\Models\Master\Cuti;
use App\Models\Pegawai\DataPengajuanCuti;
use App\Models\Pegawai\RiwayatCuti;
use App\Models\User;
use App\Repositories\Izin\IzinRepository;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;


class CutiPengajuanController extends Controller
{
    protected $izinRepository;
    function __construct(IzinRepository $izinRepository){
        $this->izinRepository = $izinRepository;
    }
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $role = role('opd');

        $qr = DataPengajuanCuti::select('data_pengajuan_cuti.*', 'users.name as name')
            ->leftJoin('users', 'users.nip', 'data_pengajuan_cuti.nip')
            ->when($search, function ($qr, $search) {
                $qr->where('data_pengajuan_cuti.nip', 'LIKE', "%$search%")
                    ->orWhere('users.name', 'LIKE', "%$search%");
            })
            ->when($role, function ($qr) {
                $user = auth()->user()->jabatan_akhir;
                $jabatan = array_key_exists('0', $user->toArray()) ? $user[0] : null;
                $skpd = '';
                if ($jabatan) {
                    $skpd = $jabatan->kode_skpd;
                }

                $qr->join('riwayat_jabatan', function ($qt) use ($skpd) {
                    $qt->on('riwayat_jabatan.nip', 'users.nip')
                        ->where('kode_skpd', $skpd)
                        ->where('is_akhir', 1);
                });
            })
            ->orderByDesc("data_pengajuan_cuti.created_at")
            ->paginate($limit);

        $qr->appends(request()->all());


        $cuti = CutiPengajuanResource::collection($qr);

        // return inertia('Pengajuan/Cuti/index', compact('cuti'));
        return view('pages/datapengajuan/pengajuancuti/index');
    }

    public function approved(DataPengajuanCuti $cuti)
    {
        // return inertia('Pengajuan/Cuti/Approved', compact('cuti'));
        return view('pages/datapengajuan/pengajuancuti/approved', compact('cuti'));
    }

    public function reject(DataPengajuanCuti $cuti)
    {
        $komentar = request('komentar');

        tambah_log($cuti->nip, "App\Pegawai\DataPengajuanCuti", $cuti->id, 'tolak');
        $up = $cuti->update([
            'komentar' => $komentar,
            'status' => '2',
        ]);

        if ($up) {
            return redirect(route('pengajuan.cuti.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, ditolak!"
            ]);
        } else {
            return redirect(route('pengajuan.cuti.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, ditolak!"
            ]);
        }
    }

    public function update()
    {
        request()->validate([
            'id' => 'required',
            'nomor_surat' => 'required',
            'tanggal_surat' => 'required',
            'komentar' => 'nullable',
            'file' => 'nullable|mimes:pdf,jpg,jpeg,png',
        ]);

        $id = request('id');
        $komentar = request('komentar');

        $cuti = DataPengajuanCuti::where('id', $id)->first();

        $file = "";
        if (request()->file('file')) {
            $ext = request()->file('file')->getClientOriginalExtension();
            $file = request()->file('file')->storeAs($cuti->nip, $cuti->nip . "-cuti-" . request('nomor_surat') . "." . $ext);
        }

        $pengajuan = [
            'komentar' => $komentar,
            'file' => $file,
            'status' => 1,
        ];



        $up = $cuti->update($pengajuan);

        if ($up) {
            # Tambah ke Total Izin Detail
            // dd($this->izinRepository->saveToTotalIzinDetail($cuti));
            if(!$this->izinRepository->saveToTotalIzinDetail($cuti)){
                return redirect()->back()->withInput()->with([
                    'type' => 'error',
                    'messages' => "Gagal, Izin tidak boleh lebih dari 12 Hari"
                ]);
            }
            # Tambah ke Riwayat Cuti
            RiwayatCuti::create([
                'nip' => $cuti->nip,
                'tanggal_mulai' => $cuti->tanggal_mulai,
                'tanggal_selesai' => $cuti->tanggal_selesai,
                'kode_cuti' => $cuti->kode_cuti,
                'file'  => $file,
                'nomor_surat' => request('nomor_surat'),
                'tanggal_surat' => request('tanggal_surat'),
            ]);
            $pegawai = User::where("nip",$cuti->nip)->first();
            $pegawai->maks_cuti = (int)$pegawai->maks_cuti - 1;
            $pegawai->update();
    
            tambah_log($cuti->nip, "App\Pegawai\DataPengajuanCuti", $id, 'terima');
            return redirect(route('pengajuan.cuti.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, diterima!"
            ]);
        } else {
            return redirect(route('pengajuan.cuti.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, diterima!"
            ]);
        }
    }

    public function datatable(DataTables $dataTables)
    {
        $model = DataPengajuanCuti::with('cuti','user')->has('user');
        return $dataTables->eloquent($model)
            ->addColumn('nama', function ($row) {
                return $row->user?->nip . "  " . $row->user?->name;
            })
            ->addColumn('cuti', function ($row) {
                return optional($row->cuti)->nama;
            })
            ->addColumn('tanggal_mulai', function ($row) {
                return tanggal_indo($row->tanggal_mulai);
            })
            ->addColumn('tanggal_selesai', function ($row) {
                return tanggal_indo($row->tanggal_selesai);
            })
            ->addColumn('status', function ($row) {
                return status_web($row->status);
            })
            ->addColumn('opsi', function ($row) {

                $html = "<a class='log me-2' tooltip='Log Pengajuan' href='" . url('logs?model_type=' . urlencode('App\Pegawai\DataPengajuanCuti') . '&model_id=' . $row->id) . "'>" . icons('cpu', 17) . "</a>";
                if ($row->status == 0) {
                    $html .= "<a class='me-2 approv text-success' tooltip='Setuju' href='" . route('pengajuan.cuti.approved', $row->id) . "'>" . icons('c-check', 17) . "</a>";
                    $html .= "<a class='me-2 reject text-danger' tooltip='Tolak' href='" . route('pengajuan.cuti.reject', $row->id) . "'>" . icons('x-circle', 17) . "</a>";
                }
                return $html;
            })
            ->rawColumns(['opsi', 'status'])
            ->addIndexColumn()
            ->toJson();
    }
}
