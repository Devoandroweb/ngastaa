<?php

namespace App\Models\Payroll;

use App\Models\Master\Payroll\Tambahan;
use App\Models\Master\Payroll\Tunjangan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DaftarTambahPayroll extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "daftar_tambah_payroll";

    protected $guarded = [];

    public function tunjangan()
    {
        return $this->belongsTo(Tunjangan::class, 'kode_tambah', 'kode_tunjangan');
    }
}
