<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MAktifitas extends Model
{
    use HasFactory;
    protected $table = "aktifitas";
    protected $fillable = ['nip','jam_mulai', 'koordinat', 'foto','keterangan'];
    function pegawai(){
        return $this->hasOne(User::class,'nip','nip');
    }

}
