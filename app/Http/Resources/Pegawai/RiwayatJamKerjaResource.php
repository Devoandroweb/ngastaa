<?php

namespace App\Http\Resources\Pegawai;

use Illuminate\Http\Resources\Json\JsonResource;

class RiwayatJamKerjaResource extends JsonResource
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
            'nama' => $this->jamKerja?->nama,
            'dari' => $this->jamKerja?->dari,
            'sampai' => $this->jamKerja?->sampai,
            'is_akhir' => $this->is_akhir,
            'created_at' => hari(date("w",strtotime($this->created_at))).", ".tanggal_indo(date("d-m-Y",strtotime($this->created_at))),
        ];
    }
}
