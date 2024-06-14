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
    protected $fillable = ['nip', 'tanggal','status','kode_cuti','tanggal_datang', 'kordinat_datang', 'foto_datang', 'tanggal_istirahat', 'kordinat_istirahat', 'foto_istirahat', 'tanggal_pulang', 'kordinat_pulang', 'foto_pulang','periode_bulan','keterangan'];
    protected $casts = [
        "created_at" => "datetime",
        "tanggal_datang" => "datetime",
        "tanggal_pulang" => "datetime",
    ];
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

    function scopeWithHadir($query){
        return $query->where("status","like","%1%");
    }
    function scopeWithTelat($query){
        return $query->where("status","like","%2%");
    }
    function scopeWithAlfa($query){
        return $query->where("status","like","%3%");
    }
    function scopeWithIzin($query){
        return $query->where("status","like","%4%");
    }
    function scopeWithTAP($query){
        return $query->where("status","like","%5%");
    }
    function scopeWithPC($query){
        return $query->where("status","like","%6%");
    }
    function scopeWithLibur($query){
        return $query->where("status","like","%7%");
    }
    function scopeWithLembur($query){
        return $query->where("status","like","%8%");
    }
    function scopeWithCuti($query){
        return $query->where("status","like","%9%");
    }
}
