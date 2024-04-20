<?php

namespace App\Http\Controllers;

use App\Http\Requests\SLoginRequest;
use App\Models\SLogin;
use App\Traits\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    use Image;
    protected $sLogin;
    function __construct(SLogin $sLogin){
        $this->sLogin = $sLogin;
    }
    function index(){
        $sLogin = $this->sLogin->first();
        return view("pages.setting.setting",compact('sLogin'));
    }
    function updatePageLogin(){
        $data = request()->validate([
            'title' => 'required',
            'desk' => 'required',
            'logo' => 'nullable',
            'cover' => 'nullable',
        ]);
        $cek = $this->sLogin->first();
        $path = 'uploads/logo/';
        if (request()->file('logo')) {
            request()->validate([
                'logo' => 'max:2048|mimes:jpg,jpeg,png',
            ]);
            if ($cek && $cek->logo != "") {
                Storage::delete($cek->logo);
            }
            $file =  request()->file('logo');
            // dd($file);
            $data['logo'] = $path.$this->uploadImage(public_path($path),$file);
        }
        if (request()->file('cover')) {
            request()->validate([
                'cover' => 'max:2048|mimes:jpg,jpeg,png',
            ]);
            if ($cek && $cek->cover != "") {
                Storage::delete($cek->cover);
            }
            $file =  request()->file('cover');
            // dd($file);
            $data['cover'] = $path.$this->uploadImage(public_path($path),$file);
        }
        $up = $this->sLogin->updateOrCreate(["id"=>1],$data);
        if ($up) {
            return redirect(route('setting.setting.index'))->with([
                'type' => 'success',
                'messages' => 'Berhasil!'
            ]);
        } else {
            return redirect(route('setting.setting.index'))->with([
                'type' => 'error',
                'messages' => 'Gagal!'
            ]);
        }
    }
}
