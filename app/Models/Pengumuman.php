<?php

namespace App\Models;

use App\Traits\LimitOffset;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    use HasFactory, LimitOffset;

    protected $table = "pengumuman";

    protected $guarded = [];
}
