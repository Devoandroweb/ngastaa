<?php

namespace App\Models\Presensi;

use App\Models\Master\Cuti;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TotalPresensi extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'total_presensi';
    protected $fillable = ['nip', 'masuk','alfa','telat','periode_bulan'];
    function totalPresensiDetail()
    {
        return $this->belongsTo(TotalPresensi::class);
    }
    function pegawai(){
        return $this->hasOne(User::class,'nip','nip');
    }
   
}
