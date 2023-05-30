<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PengumumanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if(file_exists(public_path($this->file))){
            $file = url("public/$this->file");
        }else{
            $file = asset("/dist/img/logo_lets_work_greyscale.png");
        }
        return [
            'id' => $this->id,
            'judul' => $this->judul,
            'deskripsi' => $this->deskripsi,
            'file' => $file,
            'created_at' => hari(date('N'),strtotime($this->created_at)).", ".tanggal_indo(date("Y-m-d",strtotime($this->created_at))),
        ];
    }
}
