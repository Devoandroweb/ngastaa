<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AktifitasResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'nama' => $this->pegawai->getFullName(),
            'koordinat' => $this->koordinat,
            'jabatan' => $this->pegawai->riwayat_jabatan?->first()?->tingkat?->first()->nama,
            'divisi' => $this->pegawai->riwayat_jabatan?->first()?->skpd?->first()->nama,
            'foto' => url('public/'.$this->foto),
            'created_at' => hari(date("w",strtotime($this->created_at))).", ".tanggal_indo($this->created_at),
            'dimulai_pada' => date("H:i:s",strtotime($this->created_at)),
            'keterangan' => $this->keterangan ?? "-",
        ];
    }
}
