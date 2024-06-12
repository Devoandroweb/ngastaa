<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Eselon extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'eselon';

    protected $fillable = ['kode_eselon', 'nama', 'kordinat', 'latitude', 'longitude', 'jarak'];

    public function jabatan()
    {
        $this->hasOne(Jabatan::class, 'kode_eselon', 'kode_eselon');
    }

    public function tingkat()
    {
        $this->hasOne(Tingkat::class, 'kode_eselon', 'kode_eselon');
    }
    function scopeWithFilterUserEselon($eselon=0){
        $eselon = auth()->user()->getEselon();
        if($eselon){
            return $this->where("kode_eselon",">",$eselon);
        }
    }
}
