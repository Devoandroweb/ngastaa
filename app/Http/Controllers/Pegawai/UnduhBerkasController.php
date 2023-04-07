<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\File;
use PDF;
use ZipArchive;

class UnduhBerkasController extends Controller
{
    public function index(User $pegawai)
    {
        $nip = $pegawai->nip;
        $path = public_path("storage/$nip");
        $files = File::allFiles($path);

        $dataFile = [];
        foreach ($files as $path) {
            $file = pathinfo($path);
            $send = [
                'file' => asset("storage/$nip/$file[basename]"),
                'nama' => str_replace("$nip-", "", $file["basename"]),
                'extension' =>  $file["extension"],
            ];
            array_push($dataFile, $send);
        }

        return inertia('Pegawai/Berkas/index', compact('pegawai', 'dataFile'));
    }

    public function profile(User $pegawai)
    {
        return inertia('Pegawai/Berkas/Profile', compact('pegawai'));
    }

    public function profile_pdf(User $pegawai)
    {
        // return view("pegawai.profile", compact('pegawai'));
        $pdf = PDF::loadView('pegawai.profile', compact('pegawai'))->setPaper('a4', 'potrait');
        return $pdf->stream();
    }

    public function berkas_zip(User $pegawai)
    {
        $nip = $pegawai->nip;
        $zip = new ZipArchive;

        if (true === ($zip->open("public/file-pegawai-$nip.zip", ZipArchive::CREATE | ZipArchive::OVERWRITE))) {
            $path = public_path("../data_pegawai/$nip/foto");
            $files = File::allFiles($path);
            foreach ($files as $file) {
                $name = basename($file);
                if ($name !== '.gitignore') {
                    $zip->addFile(public_path("../data_pegawai/$nip/foto/$name"), $name);
                    // dd($zip);
                }
            }
            $zip->close();
        }
        // return response()->download()
        return response()->download(public_path("file-pegawai-$nip.zip"), "file-pegawai-$nip.zip");
        // return response()->download(public_path("../data_pegawai/$nip.zip"), "file-pegawai-$nip.zip")->deleteFileAfterSend();
    }
}
