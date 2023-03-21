<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\User;
use Yajra\DataTables\DataTables;


class DataKordinatController extends Controller
{
    public function index(User $pegawai)
    {
        $view = view('pages/pegawai/pegawai/datautama/koordinat', compact('pegawai'));
        return response()->json(['view'=> $view->render()]);
        // return inertia('Pegawai/Kordinat/index', compact('pegawai'));
    }

    public function store(User $pegawai)
    {
        // dd(request()->all());
        $cr = $pegawai->update([
            'kordinat' => request('kordinat')['kordinat'],
            'latitude' => request('latitude'),
            'longitude' => request('longitude'),
            'jarak' => 0,
        ]);
        if ($cr) {
            return response()->json(["status"=>true,"msg"=>"Berhasil, diperbarui!"]);
        } else {
            return response()->json(["status"=>false,"msg"=>"Gagal, diperbarui!"]);
        }
    }

    public function reset(User $pegawai)
    {
        $cr = $pegawai->update([
            'kordinat' => null,
            'latitude' => null,
            'longitude' => null,
            'jarak' => 0,
        ]);
        if ($cr) {
            return redirect(route('pegawai.kordinat.index', $pegawai->nip))->with([
                'type' => 'success',
                'messages' => "Berhasil, direset!"
            ]);
        } else {
            return redirect(route('pegawai.kordinat.index', $pegawai->nip))->with([
                'type' => 'error',
                'messages' => "Gagal, direset!"
            ]);
        }
    }
    
}
