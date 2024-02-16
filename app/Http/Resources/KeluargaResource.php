<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class KeluargaResource extends JsonResource
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
            "id" => $this->id,
            "status" => $this->status,
            "nama" => $this->nama,
            "tempat_lahir" => $this->tempat_lahir,
            "tanggal_lahir" => tanggal_indo($this->tanggal_lahir),
            "status_kehidupan" => $this->status_kehidupan,
            "alamat" => $this->alamat,
            "nomor_telepon" => $this->nomor_telepon
        ];
    }
}
