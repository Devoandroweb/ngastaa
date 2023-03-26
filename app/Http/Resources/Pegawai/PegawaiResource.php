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
        $jabatan = array_key_exists('0', $this->jabatan_akhir->toArray()) ? $this->jabatan_akhir[0] : null;
        $shift = array_key_exists('0', $this->shift_akhir->toArray()) ? $this->shift_akhir[0] : null;
        $shift = $shift?->kode_shift;
        
        // dd($jabatan);
        $tingkat = $jabatan?->tingkat;
        $nama_jabatan =  $tingkat?->nama;
        $eselon =  $tingkat?->eselon?->nama;
        $kode_eselon =  $tingkat?->eselon?->kode_level;
        $skpd = $jabatan?->skpd?->nama;
        
        $data = [
            'nip' => $this->nip,
            'no_hp' => $this->no_hp ?? "-",
            'email' => $this->email ?? "-",
            'name' => ($this->gelar_depan ? $this->gelar_depan .". " : "-") . $this->name . ($this->gelar_belakang ? ", " . $this->gelar_belakang : ""),
            'nama_jabatan' => $nama_jabatan ?? "-",
            'eselon' => $eselon ?? "-",
            'kode_eselon' => $kode_eselon ?? 0,
            'skpd' => $skpd ?? "-",
            'images' => $this->images,
            'shift' =>  $shift,
            'image' => "public/{$this->image}",
            'tanggal_tmt' => tanggal_indo($this->tanggal_tmt),
        ];

        return $data;
    }
}
