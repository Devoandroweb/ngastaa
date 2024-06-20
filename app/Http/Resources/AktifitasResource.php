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
        $user = $this->user;
        // dd($user->riwayat_jabatan);
        return [
            'nama' => $user->fullname(),
            'koordinat' => $this->koordinat,
            'jabatan' => $user->riwayat_jabatan?->first()?->tingkat?->nama,
            'divisi' => $user->riwayat_jabatan?->first()?->skpd?->nama,
            'foto' => url('public/'.$this->foto),
            'created_at' => hari(date("w",strtotime($this->created_at))).", ".tanggal_indo($this->created_at),
            'dimulai_pada' => date("H:i:s",strtotime($this->created_at)),
            'keterangan' => $this->keterangan ?? "-",
        ];
    }
}
