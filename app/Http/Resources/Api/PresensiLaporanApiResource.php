<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class PresensiLaporanApiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $user = $this->user;
        $jabatan = $user->jabatan_akhir?->where('is_akhir',1)->first();
        return [
            'id' => $this->id,
            'nip' => $user->nip,
            'name' => $user->name,
            'divisi' => $jabatan?->skpd?->nama,
            'jabatan' => $jabatan?->tingkat?->nama,
            'jam_pagi' => $this->tanggal_datang ? date('H:i', strtotime($this->tanggal_datang)) : '-',
            'jam_siang' => $this->tanggal_istirahat ? date('H:i', strtotime($this->tanggal_istirahat)) : '-',
            'jam_sore' => $this->tanggal_pulang ? date('H:i', strtotime($this->tanggal_pulang)) : '-',
            'tanggal' => hari(date("w",strtotime($this->tanggal_datang))).", ".tanggal_indo($this->tanggal_datang)
        ];
    }
}
