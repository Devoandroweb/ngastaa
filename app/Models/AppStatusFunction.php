<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppStatusFunction extends Model
{
    use HasFactory;
    protected $table = 'app_status_function';
    public $timestamps = false;
    protected $fillable = ['name','value'];
}
