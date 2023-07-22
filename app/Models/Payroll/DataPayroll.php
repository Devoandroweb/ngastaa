<?php

namespace App\Models\Payroll;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPayroll extends Model
{
    use HasFactory;

    protected $table = "data_payroll";

    protected $guarded = [];
    protected $fillable = ['kode_payroll', 'bulan', 'tahun', 'nip', 'kode_tingkat', 'jabatan', 'divisi', 'gaji_pokok', 'tunjangan', 'persen_kehadiran', 'total_penambahan', 'total_potongan', 'total', 'is_aktif'];
    public function user()
    {
        return $this->belongsTo(User::class, 'nip', 'nip');
    }

}
