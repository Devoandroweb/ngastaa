<?php

namespace App\Http\Resources\Pegawai;

use Illuminate\Http\Resources\Json\JsonResource;

class DataVisitResource extends JsonResource
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
            'kode_visit' => $this->kode_visit,
            'visit' => $this->visit?->nama ?? "-",
            'alamat' => $this->visit?->alamat ?? "-",
            'kordinat' => $this->kordinat,
            'tanggal' => tanggal_indo($this->tanggal),
            'jam' => get_jam($this->check_in),
            'check_out' => $this->check_out != null ? get_jam($this->check_out) : null,
            'foto' => url("public".$this->foto),
        ];
    }
}
