<?php

namespace App\Repositories\Password;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Password;
use Illuminate\Support\Facades\Hash;

class PasswordRepositoryImplement extends Eloquent implements PasswordRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $auth;

    public function __construct()
    {
        
    }
    function changePassword($auth){
    // Write something awesome :)
        
        $password = request('password');
        $password_baru = request('password_baru');

        $cek = Hash::check($password, $auth->user()->password);
        if($cek){
            $pass = password_hash($password_baru, PASSWORD_BCRYPT);
            $up = $auth->user()->update(['password' => $pass]);
        }else{
            $up = false;
        }

        return $up;
    }
    function changePasswordMobile(){
        // Write something awesome :)
        $nip = request('nip');
        $password_lama = request('password_lama');
        $password_baru = request('password_baru');
        
        $user = User::where('nip',$nip)->first();

        $cek = Hash::check($password_lama, $auth->user()->password);
        if($cek){
            $user->password = password_hash($password_baru, PASSWORD_BCRYPT)
            $up = $user->update();
        }else{
            $up = false;
        }

        return $up;
    }
}
