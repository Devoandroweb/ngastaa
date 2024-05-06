<?php

namespace App\Models\Pegawai;

use App\Models\User;
use App\Traits\LimitOffset;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DataPresensi extends Model
{
    use HasFactory, SoftDeletes, LimitOffset;

    protected $table = 'data_presensi';

    protected $guarded = [];

    function user(){
        return $this->hasOne(User::class,'nip','nip');
    }

}
