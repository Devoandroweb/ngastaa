<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VPegawai extends Model
{
    use HasFactory;
    protected $table = "v_pegawai";
    function foto(){
        $jk = str_replace(" ","",$this->jenis_kelamin);
        $foto = $this->image;
        // dd($foto,file_exists(public_path("../$foto")));
        if($foto == null || $foto == "" || $foto == "NULL" || !file_exists(public_path("../$foto"))){
            if(strtolower($jk) == "laki-laki"){
                return asset('/dist/img/man.png');
            }elseif(strtolower($jk) == "perempuan"){
                return asset('/dist/img/woman.png');
            }else{
                return asset('/dist/img/man.png');
            }
        }
        return url("$foto");
        // return $foto;
    }
}
