<?php

namespace App\Models\Master;

use App\Models\Pegawai\DataPengajuanCuti;
use App\Models\Pegawai\RiwayatCuti;
use App\Models\Presensi\TotalCutiDetail;
use App\Models\Presensi\TotalPresensi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cuti extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "cuti";

    protected $guarded = [];

    public function riwayat_cuti()
    {
        return $this->hasMany(RiwayatCuti::class, 'kode_cuti', 'kode_cuti');
    }

    public function pengajuan_cuti()
    {
        return $this->hasMany(DataPengajuanCuti::class, 'kode_cuti', 'kode_cuti');
    }
    function totalPresensi(){
        return $this->hasMany(TotalPresensi::class,'kode_cuti','kode_cuti');
    }
    function totalIzinDetail(){
        return $this->hasMany(TotalCutiDetail::class,'kode_cuti','kode_cuti');
    }
}
