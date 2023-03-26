<?php

namespace App\Http\Controllers;

use App\Repositories\Password\PasswordRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UbahPassword extends Controller
{
    private $passwordRepository; 
    function __construct(PasswordRepository $passwordRepository)
    {
        $this->passwordRepository = $passwordRepository;
    }
    public function index()
    {
        return view('ubah-password');
    }

    public function update()
    {
        if($this->passwordRepository->changePassword(auth())){
            return redirect(route('password.index'))->with([
                'type' => 'success',
                'messages' => 'Berhasil!'
            ]);
        }else{
            return redirect(route('password.index'))->with([
                'type' => 'error',
                'messages' => 'Gagal!, Password lama yang anda masukkan salah'
            ]);
        }
    }
}
