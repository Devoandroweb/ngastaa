<?php

namespace App\Repositories\Password;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Password;
use App\Models\User;
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
            $pass = Hash::make($password_baru);
            return $auth->user()->update(['password' => $pass]);
        }else{
            return false;
        }
    }
    function changePasswordMobile(){
        // Write something awesome :)

        $nip = request('nip');
        $password_lama = request('password_lama');
        $password_baru = request('password_baru');

        if($password_lama == $password_baru){
            return 0;
        }
        $user = User::where('nip',$nip)->first();

        $cek = Hash::check($password_lama, $user->password);

        if($cek){

            User::where('nip',$nip)->update([
               'password' => Hash::make($password_baru)
            ]);
            return 1;
        }else{
            return 2;
        }
    }
    
}
