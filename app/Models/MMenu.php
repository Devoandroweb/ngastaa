<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MMenu extends Model
{
    use HasFactory;
    protected $table = 'm_menu';
    protected $fillable = ['kode_menu','nama'];
    
}
