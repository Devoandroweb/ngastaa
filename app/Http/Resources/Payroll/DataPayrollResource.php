<?php

namespace App\Http\Resources\Payroll;

use Illuminate\Http\Resources\Json\JsonResource;

class DataPayrollResource extends JsonResource
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
            'id' => (string) $this->id,
            'kode_payroll' => $this->kode_payroll,
            'nip' => $this->nip,
            'nama' => $this->user?->name,
            'jabatan' => $this->jabatan,
            'divisi' => $this->divisi,
            'tanggal' => "Bulan " . bulan($this->bulan) . " Tahun $this->tahun",
            'gaji_pokok' => number_indo($this->gaji_pokok),
            'total_penambahan' => number_indo($this->total_penambahan),
            'total_potongan' => number_indo($this->total_potongan),
            'total' => number_indo($this->total),
            'is_aktif' => is_aktif($this->is_aktif),
            'Dis_aktif' => (string) ($this->is_aktif),
            'slip_url' => route("payroll.generate.slip", ["dataPayroll" => $this->kode_payroll, "nip" => $this->nip]),
        ];
    }
}
