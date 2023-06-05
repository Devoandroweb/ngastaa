<?php

namespace App\Models\Pegawai;

use App\Models\Master\Visit;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DataVisit extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'data_visit';

    protected $guarded = [];

    public function visit()
    {
        return $this->belongsTo(Visit::class, 'kode_visit', 'kode_visit');
    }
    function pegawai(){
        return $this->hasOne(User::class,'nip','nip');
    }
    function foto(){
        if(file_exists(public_path("{$this->nis}/{$this->foto}"))){
            return url("public/{$this->foto}");
        }else{
            return asset('dist/img/image-not-found.png');
        }
    }
}
