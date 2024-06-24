<?php
namespace App\Traits;
use Illuminate\Database\Eloquent\Builder;
trait LimitOffset
{
    function scopeLimitOffset(Builder $query){
        return $query->offset(request('offset')??0)->limit(request('limit')??10);
    }
}


