<?php

namespace App\Models\Presensi;

use App\Models\Master\Cuti;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TotalIzinDetail extends Model
{
    use HasFactory;
    protected $table = 'total_izin_detail';
    protected $fillable = ['nip', 'kode_cuti', 'tanggal','periode_bulan'];
    function pegawai(){
        return $this->hasOne(User::class,'nip','nip');
    }
    function izin(){
        return $this->hasOne(Cuti::class,'kode_cuti','kode_cuti');
    }
}
