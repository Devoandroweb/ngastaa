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
        $file = fn() => (file_exists(public_path($this->file))) ? url("public/$this->file") : url("public/no-file.png");
        $user = $this->user;
        return [
            'id' => $this->id,
            'nip' => $user->nip,
            'nama' => $user->fullname(),
            'cuti' => $this->cuti?->nama ?? "-",
            'tanggal_mulai' => hari(date("w",strtotime($this->tanggal_mulai))).", ".tanggal_indo($this->tanggal_mulai),
            'tanggal_selesai' => hari(date("w",strtotime($this->tanggal_selesai))).", ".tanggal_indo($this->tanggal_selesai),
            'keterangan' => $this->keterangan ?? "",
            'status' => status($this->status),
            'komentar' => $this->komentar ?? "",
            'file' => $file(),
        ];
    }
}
