<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MRoleMenu extends Model
{
    use HasFactory;
    protected $table = 'role_menu';
    protected $fillable = ['kode_tingkat','kode_menu','has_permission'];
}
