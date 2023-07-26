<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\PresensiLaporanApiResource;
use App\Http\Resources\Api\PresensiListOpdApiResource;
use App\Http\Resources\Api\ShiftApiResource;
use App\Repositories\Pegawai\PegawaiRepository;
use Illuminate\Support\Str;
use App\Jobs\ProcessWaNotif;
use App\Models\Master\Lokasi;
use App\Models\Master\Shift;
use App\Models\MJamKerja;
use App\Models\Pegawai\DataPresensi;
use App\Models\Pegawai\RiwayatShift;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class PresensiApiController extends Controller
{
    protected $pegawaiRepository;
    // protected $pegawaiWithRole;
    function __construct(
        PegawaiRepository $pegawaiRepository
    ){
        $this->pegawaiRepository = $pegawaiRepository;
    }
    public function lokasi()
    {
        try{
            $nip = request('nip');
            $user = User::where('nip', $nip)->first();

            if ($user && $user->kordinat != "" && $user->longitude != "" && $user->latitude != "" && $user->jarak > 0) {
                return response()->json([
                    'kordinat' => $user->kordinat,
                    'latitude' => $user->latitude,
                    'longitude' => $user->longitude,
                    'jarak' => $user->jarak,
                    'keterangan' => 'Pegawai'
                ]);
            }

            $rwJabatan = array_key_exists('0', $user->jabatan_akhir->toArray()) ? $user->jabatan_akhir[0] : null;
            $tingkat = $rwJabatan?->tingkat;
            $kode_tingkat = $tingkat?->kode_tingkat ?? 0;
            $level = $tingkat?->eselon;
            $divisi = $rwJabatan?->skpd;
            $kode_skpd = $divisi?->kode_skpd;

            if ($rwJabatan) {
                // Jabatan
                if ($tingkat && $tingkat->kordinat != "" && $tingkat->longitude != "" && $tingkat->latitude != "" && $tingkat->jarak > 0) {
                    return response()->json(buildResponseSukses([
                        'kordinat' => $tingkat->kordinat,
                        'latitude' => $tingkat->latitude,
                        'longitude' => $tingkat->longitude,
                        'jarak' => $tingkat->jarak,
                        'keterangan' => 'Jabatan'
                    ]),200);
                }

                // Level
                if ($level && $level->kordinat != "" && $level->longitude != "" && $level->latitude != "" && $level->jarak > 0) {
                    return response()->json(buildResponseSukses([
                        'kordinat' => $level->kordinat,
                        'latitude' => $level->latitude,
                        'longitude' => $level->longitude,
                        'jarak' => $level->jarak,
                        'keterangan' => 'Level'
                    ]),200);
                }

                // Divisi
                if ($divisi && $divisi->kordinat != "" && $divisi->longitude != "" && $divisi->latitude != "" && $divisi->jarak > 0) {
                    return response()->json(buildResponseSukses([
                        'kordinat' => $divisi->kordinat,
                        'latitude' => $divisi->latitude,
                        'longitude' => $divisi->longitude,
                        'jarak' => $divisi->jarak,
                        'keterangan' => 'Divisi'
                    ]),200);
                }
            }

            // Lokasi Pegawai
            $lokasiPegawai = Lokasi::select('*')
                ->leftJoin('lokasi_detail', 'lokasi_detail.kode_lokasi', 'lokasi.kode_lokasi')
                ->whereRaw("(lokasi.keterangan = 1 AND lokasi_detail.keterangan_id = '$nip')")
                ->whereNull('lokasi_detail.deleted_at')
                ->first();
            if ($lokasiPegawai && $lokasiPegawai->kordinat != "" && $lokasiPegawai->longitude != "" && $lokasiPegawai->latitude != "" && $lokasiPegawai->jarak > 0) {

                return response()->json(buildResponseSukses([
                    'kordinat' => $lokasiPegawai->kordinat,
                    'latitude' => $lokasiPegawai->latitude,
                    'longitude' => $lokasiPegawai->longitude,
                    'jarak' => $lokasiPegawai->jarak,
                    'keterangan' => 'Lokasi Pegawai'
                ]),200);
            }

            // Lokasi Tingkat
            $lokasiTingkat = Lokasi::select('*')
                ->leftJoin('lokasi_detail', 'lokasi_detail.kode_lokasi', 'lokasi.kode_lokasi')
                ->whereRaw("(lokasi.keterangan = 2 AND lokasi_detail.keterangan_id = '$kode_tingkat')")
                ->whereNull('lokasi_detail.deleted_at')
                ->first();
            if ($lokasiTingkat && $lokasiTingkat->kordinat != "" && $lokasiTingkat->longitude != "" && $lokasiTingkat->latitude != "" && $lokasiTingkat->jarak > 0) {
                return response()->json(buildResponseSukses([
                    'kordinat' => $lokasiTingkat->kordinat,
                    'latitude' => $lokasiTingkat->latitude,
                    'longitude' => $lokasiTingkat->longitude,
                    'jarak' => $lokasiTingkat->jarak,
                    'keterangan' => 'Lokasi Tingkat'
                ]),200);
            }

            // Lokasi Divisi
            $lokasiDivisi = Lokasi::select('*')
                ->leftJoin('lokasi_detail', 'lokasi_detail.kode_lokasi', 'lokasi.kode_lokasi')
                ->whereRaw("(lokasi.keterangan = 3 AND lokasi_detail.keterangan_id = '$kode_skpd')")
                ->whereNull('lokasi_detail.deleted_at')
                ->first();
            if ($lokasiDivisi && $lokasiDivisi->kordinat != "" && $lokasiDivisi->longitude != "" && $lokasiDivisi->latitude != "" && $lokasiDivisi->jarak > 0) {
                return response()->json(buildResponseSukses([
                    'kordinat' => $lokasiDivisi->kordinat,
                    'latitude' => $lokasiDivisi->latitude,
                    'longitude' => $lokasiDivisi->longitude,
                    'jarak' => $lokasiDivisi->jarak,
                    'keterangan' => 'Lokasi Divisi'
                ]),200);
            }

            $data = [
                'kordinat' => 0,
                'latitude' => 0,
                'longitude' => 0,
                'jarak' => 0,
                'keterangan' => 'Error'
            ];

            return response()->json(buildResponseSukses($data), 200);
        } catch (\Throwable $th) {
            return response()->json(buildResponseGagal($th->getMessage()), 404);
        }
    }

    public function shift()
    {
        try{
            $nip = request('nip');

            $user = User::where('nip', $nip)->first();

            $rwJabatan = array_key_exists('0', $user->jabatan_akhir->toArray()) ? $user->jabatan_akhir[0] : null;
            $tingkat = $rwJabatan?->tingkat;
            $kode_tingkat = $tingkat?->kode_tingkat ?? 0;
            $divisi = $rwJabatan?->skpd;
            $kode_skpd = $divisi?->kode_skpd;

            $shift_pegawai = RiwayatShift::where('is_akhir', 1)->where('nip', $nip)->first();
            if($shift_pegawai){
                $kodeShift = $shift_pegawai->kode_shift;
            }else{
                $kodeShift = Lokasi::select('*')
                            ->leftJoin('lokasi_detail', 'lokasi_detail.kode_lokasi', 'lokasi.kode_lokasi')
                            ->whereRaw("(lokasi.keterangan = 1 AND lokasi_detail.keterangan_id = '$nip')")
                            ->orWhereRaw("(lokasi.keterangan = 2 AND lokasi_detail.keterangan_id = '$kode_tingkat')")
                            ->orWhereRaw("(lokasi.keterangan = 3 AND lokasi_detail.keterangan_id = '$kode_skpd')")
                            ->whereNull('lokasi_detail.deleted_at')
                            ->value('kode_shift');
            }


            $shift = Shift::where('kode_shift', $kodeShift)->first();
            $shift->kode_tingkat = $kode_tingkat;
            $data = ShiftApiResource::make($shift);

            return response()->json(buildResponseSukses($data), 200);
        } catch (\Throwable $th) {
            return response()->json(buildResponseGagal($th->getMessage()), 404);
        }
    }

    public function store()
    {
        $nip = request('nip');
        $kordinat = request('kordinat');
        $kode_shift = request('kode_shift');
        $kode_tingkat = request('kode_tingkat');

        $date = request("date");
        $toler1Min = strtotime("-5 minutes");
        // $toler1Min = strtotime('2023-07-14 07:56:00');
        $dateSend = strtotime($date);

        $timeZone = request('timezone') ?? 'WITA';

        if ($timeZone == 'WIB') {
            $tanggalIn = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s')) - (60 * 60));
            $dateSend = strtotime($date) + (60 * 60);
        } elseif ($timeZone == 'WIT') {
            $tanggalIn = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s')) + (60 * 60));
            $dateSend = strtotime($date) - (60 * 60);
        } else {
            $tanggalIn = date('Y-m-d H:i:s');
        }

        $user = User::where('nip', $nip)->with('riwayat_shift','jamKerja')->first();

        if ($dateSend < $toler1Min) {
            return response()->json(buildResponseGagal(['status' => 'Error', 'messages' => 'Harap memperbaiki jam Handphone Anda!']),400);
        }
        if (!$user) {
            return response()->json(buildResponseGagal(['status' => 'Error', 'messages' => 'User tidak ditemukan!']),400);
        }

        // blok perizinan
        // $perizinan = perizinan_pegawai($nip, date('Y-m-d'));
        // if ($perizinan) {
        //     return response()->json(['status' => 'Error', 'messages' => 'Anda sedang dalam masa perizinan!']);
        // }
        $kode_shift = null;
        $kode_jam_kerja = null;

        $jadwalShiftUser = $user->jadwalShift->where('tanggal',date('Y-m-d',strtotime($date)))->first();
        $jamKerjaUser = $user->jamKerja->where('is_akhir',1);
        $riwayatShiftUser = $user->riwayat_shift->where('is_akhir',1);

        if($jadwalShiftUser != null){
            $kode_shift = $jadwalShiftUser->kode_shift;
        }elseif($jamKerjaUser->count() > 0){
            $kode_jam_kerja = $jamKerjaUser->first()?->kode_jam_kerja;
        }elseif($riwayatShiftUser->count() > 0){
            $kode_shift = $riwayatShiftUser->first()?->kode_shift;
        }

        $shift = Shift::where('kode_shift', $kode_shift)->first();
        $jamkerja = MJamKerja::where('kode', $kode_jam_kerja)->first();

        if($shift == null && $jamkerja == null){
            return response()->json(buildResponseSukses(['status' => 'Error', 'messages' => 'Jam Kerja atau Shift Tidak Temukan !!', 'keterangan' => '']),200);
        }
        // dd($shift,$jamkerja);
        if($jamkerja != null){
            $shift = $jamkerja;
            $bukaPagiTime = strtotime($jamkerja->jam_buka_datang);
            $tutupPagiTime = strtotime($jamkerja->jam_tutup_datang);

            $bukaSiangTime = strtotime($jamkerja->jam_buka_istirahat);
            $tutupSiangTime = strtotime($jamkerja->jam_tutup_istirahat);

            $bukaSoreTime = strtotime($jamkerja->jam_buka_pulang);
            $tutupSoreTime = strtotime($jamkerja->jam_tutup_pulang);
        }else{
            $bukaPagiTime = strtotime($shift->jam_buka_datang);
            $tutupPagiTime = strtotime($shift->jam_tutup_datang);

            $bukaSiangTime = strtotime($shift->jam_buka_istirahat);
            $tutupSiangTime = strtotime($shift->jam_tutup_istirahat);

            $bukaSoreTime = strtotime($shift->jam_buka_pulang);
            $tutupSoreTime = strtotime($shift->jam_tutup_pulang);
        }


        // dd(date('Y-m-d H:i:s',$dateSend),date("Y-m-d H:i:s",$tutupPagiTime), $dateSend >= $bukaPagiTime,$dateSend <= $tutupPagiTime,"$kode_shift | $kode_jam_kerja");

        if ($dateSend >= $bukaPagiTime && $dateSend <= $tutupPagiTime) { # PAGI
        // if (true) { # PAGI
            $cek = DataPresensi::where('nip', $nip)->whereDate('tanggal_datang', date('Y-m-d'))->count();
            if ($cek > 0) {
                return response()->json(buildResponseSukses(['status' => 'Error', 'messages' => 'Anda Telah melakukan presensi pagi ini!']),200);
            } else {
                $foto = $this->uploadFotoAbsen($nip);
                $data = [
                    'nip' => $nip,
                    'periode_bulan' => date("Y-m"),
                    'kordinat_datang' => $kordinat,
                    'foto_datang' => $foto,
                    'kode_tingkat' => $kode_tingkat,
                    'kode_shift' => $kode_shift,
                    'kode_jam_kerja' => $kode_jam_kerja,
                    'tanggal_datang' => $tanggalIn
                ];
                $cr = DataPresensi::create($data);
                if ($cr) {
                    if ($user->no_hp != "") {
                        //Telat
                        if (strtotime($tanggalIn) > strtotime(date("Y-m-d", strtotime($tanggalIn)) . $shift->jam_tepat_datang)) {
                            $dateTimeObject1 = date_create(date("Y-m-d", strtotime($tanggalIn)) . " " . $shift->jam_tepat_datang);
                            $dateTimeObject2 = date_create($tanggalIn);

                            $difference = date_diff($dateTimeObject1, $dateTimeObject2);

                            $telat_pagi = $difference->h * 60;
                            $telat_pagi += $difference->i;

                            if ($telat_pagi > 0) {
                                dispatch(new ProcessWaNotif($user->no_hp, "Hallo, Anda Berhasil Melakukan Absensi, Sayangnya anda telat $telat_pagi menit! :("));
                            } else {
                                dispatch(new ProcessWaNotif($user->no_hp, 'Hallo, Anda Berhasil Melakukan Absensi Tepat Waktu Pagi ini! :D'));
                            }
                        } else {
                            dispatch(new ProcessWaNotif($user->no_hp, 'Hallo, Anda Berhasil Melakukan Absensi Tepat Waktu Pagi ini! :D'));
                        }
                    }
                    return response()->json(buildResponseSukses(['status' => 'Success', 'messages' => 'Berhasil Melakukan Absensi!', 'keterangan' => 'pagi']),200);
                } else {
                    return response()->json(buildResponseGagal(['status' => 'Error', 'messages' => 'Terjadi Kesalahan!']),400);
                }
            }
        } else if ($dateSend >= $bukaSiangTime && $dateSend <= $tutupSiangTime) {
            $cek = DataPresensi::where('nip', $nip)->whereDate('tanggal_datang', date('Y-m-d'))->first();
            if ($cek) {
                $cekSiang = DataPresensi::where('nip', $nip)->whereDate('tanggal_istirahat', date('Y-m-d'))->count();
                if ($cekSiang > 0) {
                    return response()->json(buildResponseSukses(['status' => 'Error', 'messages' => 'Anda Telah melakukan presensi siang ini!']),200);
                } else {
                    $foto = $this->uploadFotoAbsen($nip);
                    $data = [
                        'kordinat_istirahat' => $kordinat,
                        'foto_istirahat' => $foto,
                        'tanggal_istirahat' => $tanggalIn
                    ];
                    $cr = $cek->update($data);
                    if ($cr) {
                        return response()->json(buildResponseSukses(['status' => 'Success', 'messages' => 'Berhasil Melakukan Absensi!', 'keterangan' => 'siang']),200);
                    } else {
                        return response()->json(buildResponseSukses(['status' => 'Error', 'messages' => 'Terjadi Kesalahan!']),200);
                    }
                }
            } else {
                $cekSiang2 = DataPresensi::where('nip', $nip)->whereDate('tanggal_istirahat', date('Y-m-d'))->count();
                if ($cekSiang2 > 0) {
                    return response()->json(buildResponseSukses(['status' => 'Error', 'messages' => 'Anda Telah melakukan presensi siang ini!']),200);
                } else {
                    $foto = $this->uploadFotoAbsen($nip);
                    $data = [
                        'nip' => $nip,
                        'periode_bulan' => date("Y-m"),
                        'kordinat_istirahat' => $kordinat,
                        'foto_istirahat' => $foto,
                        'kode_tingkat' => $kode_tingkat,
                        'kode_shift' => $kode_shift,
                        'kode_jam_kerja' => $kode_jam_kerja,
                        'tanggal_istirahat' => $tanggalIn
                    ];
                    $cr = DataPresensi::create($data);
                    if ($cr) {
                        return response()->json(buildResponseSukses([
                            'status' => 'Success', 'messages' => 'Berhasil Melakukan Absensi!',
                            'keterangan' => 'siang'
                        ]),200);
                    } else {
                        return response()->json(buildResponseSukses(['status' => 'Error', 'messages' => 'Terjadi Kesalahan!']),200);
                    }
                }
            }
        } else if ($dateSend >= $bukaSoreTime && $dateSend <= $tutupSoreTime) {
            $cek = DataPresensi::where('nip', $nip)->whereDate('tanggal_datang', date('Y-m-d'))->first();
            $cekSiang = DataPresensi::where('nip', $nip)->whereDate('tanggal_istirahat', date('Y-m-d'))->first();
            if ($cek) {
                $cekSore = DataPresensi::where('nip', $nip)->whereDate('tanggal_pulang', date('Y-m-d'))->count();
                if ($cekSore > 0) {
                    return response()->json(buildResponseSukses(['status' => 'Error', 'messages' => 'Anda Telah melakukan presensi sore ini!']),200);
                } else {
                    $foto = $this->uploadFotoAbsen($nip);
                    $data = [
                        'periode_bulan' => date("Y-m"),
                        'kordinat_pulang' => $kordinat,
                        'foto_pulang' => $foto,
                        'tanggal_pulang' => $tanggalIn
                    ];
                    $cr = $cek->update($data);
                    if ($cr) {
                        if ($user->no_hp != "") {
                            $telatSore = telat_sore($tanggalIn, $shift->jam_tepat_pulang);
                            if ($telatSore > 0) {
                                dispatch(new ProcessWaNotif($user->no_hp, "Hallo, Anda Berhasil Melakukan Absensi, Sayangnya anda lebih cepat $telatSore menit! :("));
                            } else {
                                dispatch(new ProcessWaNotif($user->no_hp, 'Hallo, Anda Berhasil Melakukan Absensi Tepat Waktu Sore ini! :D'));
                            }
                        }
                        return response()->json(buildResponseSukses(['status' => 'Success', 'messages' => 'Berhasil Melakukan Absensi!', 'keterangan' => 'sore']),200);
                    } else {
                        return response()->json(buildResponseGagal(['status' => 'Error', 'messages' => 'Terjadi Kesalahan!']),400);
                    }
                }
            } elseif ($cekSiang) {
                $cekSore3 = DataPresensi::where('nip', $nip)->whereDate('tanggal_pulang', date('Y-m-d'))->count();
                if ($cekSore3 > 0) {
                    return response()->json(buildResponseSukses(['status' => 'Error', 'messages' => 'Anda Telah melakukan presensi sore ini!']),200);
                } else {
                    $foto = $this->uploadFotoAbsen($nip);
                    $data = [
                        'periode_bulan' => date("Y-m"),
                        'kordinat_pulang' => $kordinat,
                        'foto_pulang' => $foto,
                        'tanggal_pulang' => $tanggalIn
                    ];
                    $cr = $cekSiang->update($data);
                    if ($cr) {
                        if ($user->no_hp != "") {
                            $telatSore = telat_sore($tanggalIn, $shift->jam_tepat_pulang);
                            if ($telatSore > 0) {
                                dispatch(new ProcessWaNotif($user->no_hp, "Hallo, Anda Berhasil Melakukan Absensi, Sayangnya anda lebih cepat $telatSore menit! :("));
                            } else {
                                dispatch(new ProcessWaNotif($user->no_hp, 'Hallo, Anda Berhasil Melakukan Absensi Tepat Waktu Sore ini! :D'));
                            }
                        }
                        return response()->json(buildResponseSukses(['status' => 'Success', 'messages' => 'Berhasil Melakukan Absensi!', 'keterangan' => 'sore']),200);
                    } else {
                        return response()->json(buildResponseGagal(['status' => 'Error', 'messages' => 'Terjadi Kesalahan!']),400);
                    }
                }
            } else {
                $cekSore2 = DataPresensi::where('nip', $nip)->whereDate('tanggal_pulang', date('Y-m-d'))->count();
                if ($cekSore2 > 0) {
                    return response()->json(buildResponseSukses(['status' => 'Error', 'messages' => 'Anda Telah melakukan presensi sore ini!']));
                } else {
                    $foto = $this->uploadFotoAbsen($nip);
                    $data = [
                        'nip' => $nip,
                        'periode_bulan' => date("Y-m"),
                        'kordinat_pulang' => $kordinat,
                        'foto_pulang' => $foto,
                        'kode_tingkat' => $kode_tingkat,
                        'kode_shift' => $kode_shift,
                        'kode_jam_kerja' => $kode_jam_kerja,
                        'tanggal_pulang' => $tanggalIn
                    ];
                    $cr = DataPresensi::create($data);
                    if ($cr) {
                        if ($user->no_hp != "") {
                            $telatSore = telat_sore($tanggalIn, $shift->jam_tepat_pulang);
                            if ($telatSore > 0) {
                                dispatch(new ProcessWaNotif($user->no_hp, "Hallo, Anda Berhasil Melakukan Absensi, Sayangnya anda lebih cepat $telatSore menit! :("));
                            } else {
                                dispatch(new ProcessWaNotif($user->no_hp, 'Hallo, Anda Berhasil Melakukan Absensi Tepat Waktu Sore ini! :D'));
                            }
                        }
                        $data = [
                            'messages' => 'Berhasil Melakukan Absensi!',
                            'keterangan' => 'sore'
                        ];
                        return response()->json(buildResponseSukses($data), 200);
                        // return response()->json(['status' => 'Success', 'messages' => 'Berhasil Melakukan Absensi!', 'keterangan' => 'sore']);
                    } else {
                        return response()->json(buildResponseGagal(['status' => 'Error', 'messages' => 'Terjadi Kesalahan!']),400);
                    }
                }
            }
        } else {

            return response()->json(buildResponseSukses(['status' => 'Error', 'messages' => "Anda tidak berada diwaktu presensi"]),200);
        }
    }

    public function index()
    {
        try{
            $nip = request('nip');

            $data = DataPresensi::where('nip', $nip)->whereDate('created_at', date('Y-m-d'))->first();
            $datang = $data ? $data->tanggal_datang : false;
            $istirahat = $data ? $data->tanggal_istirahat : false;
            $pulang = $data ? $data->tanggal_pulang : false;

            $data = [
                'nip' => $nip,
                'datang' => $datang ? TRUE : FALSE,
                'waktu_datang' => $datang ? date('H:i:s', strtotime($datang)) : '-',
                'pulang' => $pulang ? TRUE : FALSE,
                'waktu_pulang' => $pulang ? date('H:i:s', strtotime($pulang)) : '-',
                'istirahat' => $istirahat ? TRUE : FALSE,
                'waktu_istirahat' => $istirahat ? date('H:i:s', strtotime($istirahat)) : '-',
            ];

            return response()->json(buildResponseSukses($data), 200);
        } catch (\Throwable $th) {
            return response()->json(buildResponseGagal($th->getMessage()), 404);
        }
    }

    public function lists()
    {
        try{
            $periodeBulan = date('Y-m');
            $nip = request()->query('nip');
            $kodeSkpd = request()->query('kode_skpd');
            $user = User::where('nip',$nip)->first();
            $levelJabatanUser = $user->jabatan_akhir->first()?->tingkat?->eselon->kode_eselon;
            if(!$user){
                return response()->json(buildResponseSukses(['status'=>false,'messages'=>'NIP tidak di temukan']),200);
            }
                // dd($opd);
            // $arrayNip = $this->pegawaiRepository->allPegawaiWithRole($levelJabatanUser, $kodeSkpd)->pluck('nip')->toArray();
            $date = request('d') ? date('Y-m-d', strtotime(request('d'))) : date('Y-m-d', strtotime('-1 days'));
            $end =  request('e') ? date('Y-m-d', strtotime(request('e')) + (60 * 60 * 24)) : date('Y-m-d');
            if($user){
                // $data = DataPresensi::select('data_presensi.id', 'data_presensi.nip', 'users.name','tanggal_datang', 'tanggal_istirahat', 'tanggal_pulang', 'data_presensi.created_at')
                //                     ->leftJoin('users', 'users.nip', 'data_presensi.nip')
                //                     ->where('data_presensi.nip', $nip)
                //                     ->where('data_presensi.periode_bulan', $periodeBulan)
                //                     // ->whereBetween('data_presensi.created_at', [$date, $end])
                //                     ->get();
                $data = DataPresensi::whereHas('user',function($q) use ($nip){
                    $q->where('nip',$nip);
                })->where('periode_bulan',$periodeBulan)->get();
                $data = PresensiLaporanApiResource::collection($data);
                if($data){
                    return response()->json(buildResponseSukses($data),200);
                }else{
                    return response()->json(buildResponseSukses(['status' => FALSE, 'messages' => 'Anda tidak memiliki pengajuan!' ]),200);
                }
            }else{
                return response()->json(buildResponseSukses(['status' => FALSE, 'messages' => 'User tidak ditemukan!' ]),200);
            }
        } catch (\Throwable $th) {
            return response()->json(buildResponseGagal($th->getMessage()), 404);
        }
    }
    public function listsOpd()
    {
        try{
            $periodeBulan = date('Y-m');
            $nip = request()->query('nip');
            $kodeSkpd = request()->query('kode_skpd');
            $user = User::where('nip',$nip)->first();
            if(!$user){
                return response()->json(buildResponseSukses(['status'=>false,'messages'=>'NIP tidak di temukan']),200);
            }
                // dd($opd);
            $arrayNip = $this->pegawaiRepository->allPegawaiWithRole($kodeSkpd, true)->pluck('users.nip')->toArray();
            $date = request('d') ? date('Y-m-d', strtotime(request('d'))) : date('Y-m-d', strtotime('-1 days'));
            $end =  request('e') ? date('Y-m-d', strtotime(request('e')) + (60 * 60 * 24)) : date('Y-m-d');
            if($user){
                $data = DataPresensi::whereIn('nip',$arrayNip)->where('periode_bulan',$periodeBulan)->get();
                $data = PresensiListOpdApiResource::collection($data);
                if($data){
                    return response()->json(buildResponseSukses($data),200);
                }else{
                    return response()->json(buildResponseSukses(['status' => FALSE, 'messages' => 'Anda tidak memiliki pengajuan!' ]),200);
                }
            }else{
                return response()->json(buildResponseSukses(['status' => FALSE, 'messages' => 'User tidak ditemukan!' ]),200);
            }
        } catch (\Throwable $th) {
            return response()->json(buildResponseGagal($th->getMessage()), 404);
        }
    }
    function uploadFotoAbsen($nip){
        if (request()->file('image')) {
            $file =  request()->file('image');
            $path = "uploads/presensi/$nip";
            $foto = $path."/".uploadImage(public_path($path),$file);
        }else{
            $foto = "";
        }

        return $foto;
    }
}
