<?php

namespace App\Models\Master\Payroll;

use App\Models\Kabupaten;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Umk extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "umk";

    protected $fillable = [
        'kode_umk', 
        'nama_umk',
        'nominal',
        'kode_kabupaten', 
        'tahun',
        
    ];

    public function kabupaten()
    {
        return $this->hasOne(Kabupaten::class, 'code', 'kode_kabupaten');
    }
}
