<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class NotPresentExcel implements FromView
{
    protected $notPresent;
    function __construct($notPresent)
    {
        $this->notPresent = $notPresent;
    }
    public function view(): View
    {
        return view('laporan.presensi.presensi-not-present', [
            'notPresent' => $this->notPresent
        ]);
    }
}
