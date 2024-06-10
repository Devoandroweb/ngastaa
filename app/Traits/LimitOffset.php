<?php
namespace App\Traits;
trait LimitOffset
{
    function scopeLimitOffset(){
        return $this->limit(request('limit')??10)->offset(request('offset')??0);
        // return $this->offset(request('offset')??0);
    }
}


