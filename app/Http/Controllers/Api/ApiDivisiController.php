<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Master\Skpd;
use Illuminate\Http\Request;

class ApiDivisiController extends Controller
{
    function list(){
        try{
            $data = Skpd::orderBy('nama')->get(['kode_skpd','nama']);
            return response()->json(buildResponseSukses($data),200);
        } catch (\Throwable $th) {
            return response()->json(buildResponseSukses($th->getMessage()),400);
        }
    }
}
