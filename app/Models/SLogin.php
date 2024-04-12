<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SLogin extends Model
{
    use HasFactory;
    protected $table = "s_login";
    public $timestamps = false;
    protected $fillable = ["title","desk","logo","cover"];
    function logo(){
        if($this->logo){
            return $this->logo;
        }
        $perusahaan = Perusahaan::first();
        return $perusahaan->no_image;

    }
}
