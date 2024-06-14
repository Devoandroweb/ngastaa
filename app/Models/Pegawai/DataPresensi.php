<?php

namespace App\Models\Pegawai;

use App\Models\HariJamKerja;
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
    protected $casts = [
        "created_at" => "datetime",
        "tanggal_datang" => "datetime",
    ];
    function user(){
        return $this->belongsTo(User::class,'nip','nip');
    }
    function hJamKerja($hari){
        return $this->hasOne(HariJamKerja::class,"kode_jam_kerja","kode_jam_kerja")->whereHari($hari);
    }

}
