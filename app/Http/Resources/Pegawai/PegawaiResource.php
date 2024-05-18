<?php

namespace App\Http\Resources\Pegawai;

use Illuminate\Http\Resources\Json\JsonResource;

class PegawaiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $jabatan = $this->jabatan_akhir->load('tingkat','skpd')->first();
        $shift = $this->shift_akhir->first();
        $shift = $shift?->kode_shift;

        // dd($jabatan);
        $tingkat = $jabatan?->tingkat->load('eselon');
        $nama_jabatan =  $tingkat?->nama;
        $eselon =  $tingkat?->eselon;
        $nama_eselan = $eselon?->nama;
        $kode_eselon =  $eselon?->kode_eselon;
        $skpd = $jabatan?->skpd?->nama;

        $data = [
            'nip' => $this->nip,
            'no_hp' => $this->no_hp ?? "-",
            'email' => $this->email ?? "-",
            'name' => ($this->gelar_depan ? $this->gelar_depan ." " : "") . $this->name . ($this->gelar_belakang ? ", " . $this->gelar_belakang : ""),
            'nama_jabatan' => $nama_jabatan ?? "-",
            'eselon' => $nama_eselan ?? "-",
            'kode_eselon' => $kode_eselon ?? "0",
            'skpd' => $skpd ?? "-",
            'images' => $this->images,
            'shift' =>  $shift,
            'status_password' => $this->status_password,
            'image' => $this->foto(),
            'tanggal_tmt' => tanggal_indo($this->tanggal_tmt),
        ];

        return $data;
    }
}
