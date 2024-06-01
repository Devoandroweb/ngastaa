<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class PresentTodayExcel implements FromView
{
    public function view(): View
    {
        $presensiToday = getPresensi();
        $nipArray = array_column($presensiToday, 'nip');
        $presensiToday = User::selectRaw('users.*, riwayat_jabatan.*')
                                    ->leftJoin('riwayat_jabatan', 'riwayat_jabatan.nip', 'users.nip')
                                    ->where('riwayat_jabatan.is_akhir', 1)
                                    ->whereIn('users.nip',$nipArray)
                                    ->get();
        return view('laporan.presensi.presensi-today', [
            'presensiToday' => $presensiToday
        ]);
    }
}
