<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class PresensiListOpdApiResource extends JsonResource
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
            'id' => $this->id,
            'nip' => $this->nip,
            'name' => $this->user->name,
            'divisi' => $this->user->jabatan_akhir?->where('is_akhir',1)->first()?->skpd?->nama,
            'jabatan' => $this->user->jabatan_akhir?->where('is_akhir',1)->first()?->tingkat?->nama,
            'jam_pagi' => $this->tanggal_datang ? date('H:i', strtotime($this->tanggal_datang)) : '-',
            'jam_siang' => $this->tanggal_istirahat ? date('H:i', strtotime($this->tanggal_istirahat)) : '-',
            'jam_sore' => $this->tanggal_pulang ? date('H:i', strtotime($this->tanggal_pulang)) : '-',
            'tanggal' => hari(date("w",strtotime($this->created_at))).", ".tanggal_indo($this->created_at)
        ];
    }
}
