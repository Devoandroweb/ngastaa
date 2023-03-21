<?php

namespace App\Models\Presensi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TotalIzin extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'total_izin';
    protected $fillable = ['nip', 'kode_cuti','total'];
}
