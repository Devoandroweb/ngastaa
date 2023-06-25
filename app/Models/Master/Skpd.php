<?php

namespace App\Models\Master;

use App\Models\Pegawai\RiwayatJabatan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Skpd extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'skpd';

    protected $fillable = ['kode_skpd', 'nama', 'singkatan', 'kordinat', 'latitude', 'longitude', 'jarak','polygon'];

    protected $parents = [
        'image',
    ];

    public function tingkat()
    {
        return $this->hasOne(Tingkat::class, 'kode_skpd', 'kode_skpd');
    }
    public function tingkatMany()
    {
        return $this->hasMany(Tingkat::class, 'kode_skpd', 'kode_skpd');
    }

    public function riwayat_jabatan()
    {
        return $this->hasMany(RiwayatJabatan::class, 'kode_skpd', 'kode_skpd');
    }

    public function bidang()
    {
        return $this->hasMany(Bidang::class, 'kode_skpd', 'kode_skpd');
    }

    public function seksi()
    {
        return $this->hasMany(Seksi::class, 'kode_skpd', 'kode_skpd');
    }

    // public function getParentsAttribute()
    // {
    //     $parents = collect([]);

    //     $parent = $this->atasan;

    //     while (!is_null($parent)) {
    //         $parents->push($parent);
    //         $parent = $parent->atasan;
    //     }

    //     return $parents;
    // }
}
