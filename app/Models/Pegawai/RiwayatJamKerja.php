<?php

namespace App\Models\Pegawai;

use App\Models\MJamKerja;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RiwayatJamKerja extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = "riwayat_jam_kerja";
    protected $fillable = ['nip', 'kode_jam_kerja','is_akhir','status'];
    function jamKerja(){
        return $this->hasOne(MJamKerja::class,'kode','kode_jam_kerja');
    }
    function jamKerjaDay(){
        return $this->hasMany(HariJamKerja::class,'kode','kode_jam_kerja');
    }
}
