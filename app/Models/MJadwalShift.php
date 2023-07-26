<?php

namespace App\Models;

use App\Models\Master\Shift;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MJadwalShift extends Model
{
    use HasFactory;
    protected $table = "jadwal_shift";
    protected $fillable = ['nip','kode_shift','tanggal'];

    function jamKerja(){
        return $this->hasOne(MJamKerja::class,'kode_jam_kerja','kode_shift');
    }
    function shift(){
        return $this->hasOne(Shift::class,'kode_shift','kode_shift');
    }
}
