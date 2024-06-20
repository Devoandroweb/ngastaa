<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MAktifitas extends Model
{
    use HasFactory;
    protected $table = "aktifitas";
    protected $fillable = ['nip','jam_mulai', 'koordinat', 'foto','keterangan'];
    function user(){
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
