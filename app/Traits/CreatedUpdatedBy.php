<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait CreatedUpdatedBy
{
    public static function bootCreatedUpdatedBy()
    {
        $guard = "web";
        
        // if(auth()->guard('siswa')->check()){
        //     $guard = 'siswa';
        // }
        // updating created_by and updated_by when model is created
        static::creating(function ($model) use ($guard) {
            if (!$model->isDirty('created_by')) {
                $model->created_by = Auth::guard($guard)->user()->id;
            }
            if (!$model->isDirty('updated_by')) {
                $model->updated_by = Auth::guard($guard)->user()->id;
            }
        });
        // updating updated_by when model is updated
        static::updating(function ($model) use ($guard) {
            if (!$model->isDirty('updated_by')) {
                $model->updated_by = Auth::guard($guard)->user()->id;
            }
        });
    }
}
