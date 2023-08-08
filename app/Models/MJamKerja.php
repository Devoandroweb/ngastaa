<?php

namespace App\Models;

use App\Models\Pegawai\RiwayatJamKerja;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MJamKerja extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'm_jam_kerja';

    protected $guarded = [];

    public function riwayat_jam_kerja()
    {
        return $this->hasMany(RiwayatJamKerja::class, 'kode', 'kode_jam_kerja');
    }
    public function hariJamKerja()
    {
        return $this->hasMany(HariJamKerja::class, 'kode_jam_kerja', 'kode');
    }
}
