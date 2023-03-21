<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use Illuminate\Support\Facades\Storage;

class PerusahaanController extends Controller
{
    public function index()
    {
        $perusahaan = Perusahaan::find(1);
        if (!$perusahaan) {
            $perusahaan = new Perusahaan();
        }

        // return inertia('Perusahaan/edit', compact('perusahaan'));
        return view('pages/perusahaan/index', compact('perusahaan'));
    }

    public function update()
    {
        // dd(request()->all());
        $data = request()->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'kontak' => 'nullable',
            'direktur' => 'required',
            'nomor' => 'nullable',
            'website' => 'nullable',
        ]);
        $cek = Perusahaan::first();
        if (request()->file('logo')) {
            request()->validate([
                'logo' => 'max:2048|mimes:jpg,jpeg,png',
            ]);
            if ($cek && $cek->logo != "") {
                Storage::delete($cek->logo);
            }
            $file =  request()->file('logo');
            // dd($file);
            $data['logo'] = 'uploads/logo/'.$this->uploadImage(public_path('uploads/logo/'),$file);
        }

        if ($cek) {
            $id = $cek->id;
        } else {
            $id = request('id');
        }
        // dd($data);
        $up = Perusahaan::updateOrCreate(['id' => $id], $data);

        if ($up) {
            return redirect(route('perusahaan.index'))->with([
                'type' => 'success',
                'messages' => 'Berhasil!'
            ]);
        } else {
            return redirect(route('perusahaan.index'))->with([
                'type' => 'error',
                'messages' => 'Gagal!'
            ]);
        }
    }
    public function uploadImage($dir, $file)
    {
        $result = null;
        $namaFile = time() . "_" . $file->getClientOriginalName();
        // $ext = $file->getClientOriginalExtension();
        $filename = $file->move($dir, $namaFile);
        $result = $filename->getFileName();
        return $result;
    }
}
