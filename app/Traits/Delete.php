<?php
namespace App\Traits;
trait Delete {
    function delete($model){
        return $model->delete();
    }
}
