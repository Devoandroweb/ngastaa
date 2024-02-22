<?php

namespace App\Models\Pegawai;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RiwayatOrganisasi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "riwayat_organisasi";

    protected $guarded = [];

    function user(){
        return $this->belongsTo(User::class, 'nip', 'nip');
    }
}
