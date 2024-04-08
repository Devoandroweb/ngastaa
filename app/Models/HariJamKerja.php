<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HariJamKerja extends Model
{
    use HasFactory;
    protected $table = "hari_jam_kerja";
    protected $fillable = ['kode_jam_kerja', 'hari', 'jam_buka_datang', 'jam_tepat_datang', 'jam_tutup_datang', 'toleransi_datang', 'jam_buka_istirahat', 'jam_tepat_istirahat', 'jam_tutup_istirahat', 'toleransi_istirahat', 'jam_buka_pulang', 'jam_tepat_pulang', 'jam_tutup_pulang', 'toleransi_pulang','tipe','parent'];
    function jamKerja(){
        return $this->belongsTo(MJamKerja::class,'kode_jam_kerja','kode');
    }
}
