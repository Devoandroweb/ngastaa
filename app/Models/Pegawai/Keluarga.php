<?php

namespace App\Models\Pegawai;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Keluarga extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'keluarga';
    protected $guarded = [];

    public static function keluargaPegawai()
    {
        return static::where('nip', auth()->user()->nip);
    }
}
