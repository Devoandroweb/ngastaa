<?php

namespace App\Models\Payroll;

use App\Models\Master\Payroll\Tambahan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarBonusPayroll extends Model
{
    use HasFactory;
    protected $table = 'daftar_bonus_payroll';
    protected $fillable = ['kode_bonus', 'is_periode', 'bulan', 'tahun', 'keterangan', 'kode_keterangan', 'created_at', 'updated_at', 'deleted_at'];

    function tambah(){
        return $this->hasOne(Tambahan::class, 'kode_tambah', 'kode_bonus');
    }
}
