<?php
namespace App\Traits;
trait MessageStore {
    function getMessage(){
        if(request('id')){
            return "di Ubah";
        }else{
            return "di Tambahkan";
        }
    }
}
