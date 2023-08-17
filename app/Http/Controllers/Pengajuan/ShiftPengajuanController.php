<?php

namespace App\Http\Controllers\Pengajuan;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\RiwayatShiftResource;
use App\Jobs\ProcessWaNotif;
use App\Models\Pegawai\RiwayatShift;
use App\Repositories\Shift\ShiftRepository;
use Yajra\DataTables\DataTables;

class ShiftPengajuanController extends Controller
{
    protected $shiftRepository;
    function __construct(ShiftRepository $shiftRepository){
        $this->shiftRepository = $shiftRepository;
    }
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $role = role('opd');

        $qr = RiwayatShift::select('riwayat_shift.*', 'users.name as name')
            ->leftJoin('users', 'users.nip', 'riwayat_shift.nip')
            ->when($search, function ($qr, $search) {
                $qr->where('riwayat_shift.nip', 'LIKE', "%$search%")
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
                        ->where('riwayat_jabatan.kode_skpd', $skpd)
                        ->where('riwayat_jabatan.is_akhir', 1);
                });
            })
            ->orderByDesc("riwayat_shift.created_at")
            ->where("status", '!=', 99)
            ->paginate($limit);

        $qr->appends(request()->all());


        $shift = RiwayatShiftResource::collection($qr);
        // return inertia('Pengajuan/Shift/index', compact('shift'));
        return view('pages/datapengajuan/pengajuanshift/index');
    }

    public function approved(RiwayatShift $shift)
    {
        // return inertia('Pengajuan/Shift/Approved', compact('shift'));
        return view('pages/datapengajuan/pengajuanshift/approved', compact('shift'));
    }

    public function reject(RiwayatShift $shift)
    {
        $komentar = request('komentar');

        $no_hp = $shift?->user?->no_hp;
        if ($no_hp) {
            dispatch(new ProcessWaNotif($no_hp, "Pengajuan {$shift?->shift?->nama} Ditolak karena $komentar"));
        }

        tambah_log($shift->nip, "App\Pegawai\RiwayatShift", $shift->id, 'tolak');
        $up = $shift->update([
            'komentar' => $komentar,
            'status' => '2',
        ]);

        if ($up) {
            return redirect(route('pengajuan.shift.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, ditolak!"
            ]);
        } else {
            return redirect(route('pengajuan.shift.index'))->with([
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

        $shift = RiwayatShift::where('id', $id)->first();

        $file = "";
        if (request()->file('file')) {
            $ext = request()->file('file')->getClientOriginalExtension();
            $file = request()->file('file')->storeAs($shift->nip, $shift->nip . "-shift-" . request('nomor_surat') . "." . $ext);
        }

        RiwayatShift::where("nip", $shift->nip)->update(['is_akhir' => 0]);

        $pengajuan = [
            'komentar' => $komentar,
            'file' => $file,
            'status' => 1,
            'is_akhir' => 1,
            'nomor_surat' => request('nomor_surat'),
            'tanggal_surat' => request('tanggal_surat'),
        ];

        tambah_log($shift->nip, "App\Pegawai\RiwayatShift", $id, 'terima');

        $up = $shift->update($pengajuan);
        # Penjadwalan SHift
        $this->shiftRepository->updatePenjadwalanShiftWithRangeDate($shift->nip,$shift->kode_shift,$shift->untuk_tanggal);

        if ($up) {
            $no_hp = $shift?->user?->no_hp;
            if ($no_hp) {
                $catatan = "";
                if ($komentar) {
                    $catatan = ", Catatan : $komentar";
                }
                dispatch(new ProcessWaNotif($no_hp, "Pengajuan {$shift?->shift?->nama} telah diterima $catatan!"));
            }

            return redirect(route('pengajuan.shift.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, diterima!"
            ]);
        } else {
            return redirect(route('pengajuan.shift.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, diterima!"
            ]);
        }
    }
    public function datatable(DataTables $dataTables)
    {
        $role = role('opd');
        $search = request('s');

        $qr = RiwayatShift::select('riwayat_shift.*', 'users.name as name')
            ->leftJoin('users', 'users.nip', 'riwayat_shift.nip')
            ->when($search, function ($qr, $search) {
                $qr->where('riwayat_shift.nip', 'LIKE', "%$search%")
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
                        ->where('riwayat_jabatan.kode_skpd', $skpd)
                        ->where('riwayat_jabatan.is_akhir', 1);
                });
            })
            ->orderByDesc("riwayat_shift.created_at");
            // dd($qr);
        return $dataTables->of($qr)
            ->addColumn('name', function ($row) {
                return $row->nip . "  " . $row->name;
            })
            ->addColumn('nama_shift', function ($row) {
                return $row->shift?->nama;
            })
            ->addColumn('status', function ($row) {
                return status_web($row->status);
            })
            ->addColumn('opsi', function ($row) {

                $html = "<a class='log me-2' tooltip='Log Pengajuan' href='" . url('logs?model_type=' . urlencode('App\Pegawai\DataPengajuanshift') . '&model_id=' . $row->id) . "'>" . icons('cpu', 17) . "</a>";
                if ($row->status == 0) {
                    $html .= "<a class='me-2 approv text-success' tooltip='Setuju' href='" . route('pengajuan.shift.approved', $row->id) . "'>" . icons('c-check', 17) . "</a>";
                    $html .= "<a class='me-2 reject text-danger' tooltip='Tolak' href='" . route('pengajuan.shift.reject', $row->id) . "'>" . icons('x-circle', 17) . "</a>";
                }
                return $html;
            })
            ->rawColumns(['opsi', 'status'])
            ->addIndexColumn()
            ->toJson();
    }
}
