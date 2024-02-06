<?php

namespace App\Models\Master;

use App\Models\MapLokasiKerja;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lokasi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'lokasi';

    protected $guarded = [];
    function mapLokasiKerja(){
        return $this->hasMany(MapLokasiKerja::class,'kode_lokasi','kode_lokasi');
    }
    function skpd(){
        return $this->hasOne(Skpd::class,'kode_skpd','kode_skpd');
    }
}
