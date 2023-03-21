<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ImportPegawaiExcell implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row ) {
            $item = new User();
            $item->nip = $row[0];
            $item->nik = $row[1];
            $item->name = $row[1];
            $item->gelar_depan = $row[2];
            $item->gelar_belakang = $row[2];
            $item->tempat_lahir = $row[2];
            $item->tlahir = $row[3];
            $item->jenis_kelamin = $row[4];
            $item->kode_agama = $row[5];
            $item->golongan_darah = $row[6];
            $item->kode_status = $row[7];
            $item->no_hp = $row[8];
            $item->email = $row[9];
            $item->alamat = $row[10];
            $item->alamat_ktp = $row[11];
            $item->save();
        }
    }
}
