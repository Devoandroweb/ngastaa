<?php

namespace App\Models\Payroll;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollTambah extends Model
{
    use HasFactory;

    protected $table = "payroll_tambah";

    protected $guarded = [];

    protected $fillable = ['kode_payroll', 'nip', 'kode_tambahan', 'keterangan', 'nilai'];

}
