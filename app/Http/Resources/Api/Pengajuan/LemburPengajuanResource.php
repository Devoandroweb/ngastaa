<?php

namespace App\Http\Resources\Api\Pengajuan;

use Illuminate\Http\Resources\Json\JsonResource;

class LemburPengajuanResource extends JsonResource
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
            'nama' => $user->fullname(),
            'jam_mulai' => $this->jam_mulai,
            'jam_selesai' => $this->jam_selesai,
            'tanggal' => hari(date("w",strtotime($this->tanggal))).", ".tanggal_indo($this->tanggal),
            'keterangan' => $this->keterangan ?? "",
            'status' => status($this->status),
            'komentar' => $this->komentar ?? "",
            'file' => $file(),
        ];
    }
}
