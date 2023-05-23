<?php

namespace App\Http\Resources\Api\Pengajuan;

use Illuminate\Http\Resources\Json\JsonResource;

class ReimbursementPengajuanResource extends JsonResource
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
            'reimbursement' => optional($this->reimbursement)->nama,
            'nilai' => number_indo($this->nilai),
            'keterangan' => $this->keterangan ?? "",
            'status' => status($this->status),
            'komentar' => $this->komentar ?? "",
            'file' => storage($this->file),
            'created_at' => hari(date('N'),strtotime($this->created_at)).", ".tanggal_indo(date("Y-m-d",strtotime($this->created_at)))
        ];
    }
}
