<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanPermit extends Model
{
    use HasFactory;
    protected $table = "pengajuan_permit";
    protected $fillable = ["nip", "tanggal", "jam_keluar", "jam_kembali", "keperluan", "ttd", "status"];
    function user(){
        return $this->hasOne(User::class,"nip","nip");
    }
}
