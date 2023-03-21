<?php

namespace App\Http\Resources\Pegawai;

use Illuminate\Http\Resources\Json\JsonResource;

class DataPresensiResource extends JsonResource
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
            'nama' => $this->nama,
            'nip' => $this->nip,
            'jabatan' => $this->jabatan,
            'tanggal' => tanggal_indo($this->created_at),
            'jam_datang' => get_jam($this->tanggal_datang),
            'jam_istirahat' => get_jam($this->tanggal_istirahat),
            'jam_pulang' => get_jam($this->tanggal_pulang),
        ];
    }
}
