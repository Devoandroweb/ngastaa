<?php

namespace App\Models\Presensi;

use App\Models\Master\Cuti;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TotalPresensiDetail extends Model
{
    use HasFactory;
    protected $table = 'total_presensi_detail';
    protected $fillable = ['nip', 'tanggal','status','kode_cuti','tanggal_datang', 'kordinat_datang', 'foto_datang', 'tanggal_istirahat', 'kordinat_istirahat', 'foto_istirahat', 'tanggal_pulang', 'kordinat_pulang', 'foto_pulang','periode_bulan'];
    function totalPresensi()
    {
        return $this->hasMany(TotalPresensi::class);
    }
    function pegawai(){
        return $this->hasOne(User::class,'nip','nip');
    }
    function izin(){
        return $this->hasOne(Cuti::class,'kode_cuti','kode_cuti');
    }
}
