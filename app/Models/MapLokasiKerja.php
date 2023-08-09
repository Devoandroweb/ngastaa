<?php

namespace App\Models;

use App\Models\Master\Lokasi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MapLokasiKerja extends Model
{
    use HasFactory;
    protected $table = 'manage_lokasi_kerja';
    protected $fillable = ['kode_lokasi','nip'];
    function lokasiKerja(){
        return $this->hasOne(Lokasi::class,'kode_lokasi','kode_lokasi');
    }
    function pegawai(){
        return $this->hasMany(User::class,'nip','nip');
    }
}
