<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFace extends Model
{
    use HasFactory;
    protected $table = 'user_face';
    protected $fillable = ['nip','face_image'];

    function user(){
        return $this->hasOne(User::class,'nip','nip');
    }
}
