<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\PosisiResource;
use App\Models\User;

class DataPosisiControlller extends Controller
{
    public function index(User $pegawai)
    {
        PosisiResource::withoutWrapping();
        $pegawai = PosisiResource::make($pegawai);
        // return inertia('Pegawai/Posisi/index', compact('pegawai'));
        $view = view('pages/pegawai/pegawai/datautama/posisi', compact('pegawai'));
        return response()->json(['view'=> $view->render()]);
    }
}
