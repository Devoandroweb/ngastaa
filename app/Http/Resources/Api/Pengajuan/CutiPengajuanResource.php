<?php

namespace App\Http\Resources\Api\Pengajuan;

use Illuminate\Http\Resources\Json\JsonResource;

class CutiPengajuanResource extends JsonResource
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
            'cuti' => $this->cuti?->nama ?? "-",
            'tanggal_mulai' => hari(date("w",strtotime($this->tanggal_mulai))).", ".tanggal_indo($this->tanggal_mulai),
            'tanggal_selesai' => hari(date("w",strtotime($this->tanggal_selesai))).", ".tanggal_indo($this->tanggal_selesai),
            'keterangan' => $this->keterangan ?? "",
            'status' => status($this->status),
            'komentar' => $this->komentar ?? "",
            'file' => storage($this->file),
        ];
    }
}
