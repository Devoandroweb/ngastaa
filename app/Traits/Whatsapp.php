<?php
namespace App\Traits;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Http;

trait Whatsapp {
    function sendMessage($number,$msg){
        // dd($number);
        $response = Http::withHeaders([
            'Authorization' => config('app.wa_token'), // Ganti TOKEN dengan token aktual Anda
        ])->post('https://api.fonnte.com/send', [
            'target' => $number,
            'message' => $msg,
            'countryCode' => '62', // Opsional
            'delay'=>'0',
            // 'buttonJson' => $buttonJson
        ]);
        // dd($response->body());
        $rs = json_decode($response->body());
        if(!$rs->status){
            $fileError = fopen('error_whatsapp.txt','a');
            fwrite($fileError, $rs->reason." | ". now());
            fclose($fileError);
            throw new HttpResponseException(response()->json(['error_wa' => $rs->reason], 500));
        }
        if ($response->failed()) {
            $error_msg = $response->body();
            return response()->json(['error_wa' => $error_msg], 500);
        }
        $fileError = fopen('error_whatsapp.txt','a');
        fwrite($fileError, $response->body()." | ". now()."\n");
        fclose($fileError);
        // dd($response->body());
        return $response->body();
    }
    function verif($number){
        
        $response = Http::withHeaders([
            'Authorization' => config('app.wa_token'), // Ganti TOKEN dengan token aktual Anda
        ])->post('https://api.fonnte.com/validate', [
            'target' => $number,
            'countryCode' => '62', // Opsional
        ]);
        // dd($response->body());
        $rs = json_decode($response->body());
        if(!$rs->status){
            $fileError = fopen('error_whatsapp.txt','a');
            fwrite($fileError, $rs->reason." | ". now());
            fclose($fileError);
            throw new HttpResponseException(response()->json(['error_wa' => $rs->reason], 500));
        }
        if ($response->failed()) {
            $error_msg = $response->body();
            return response()->json(['error_wa' => $error_msg], 500);
        }
        // dd($response->body());
        return $response->body();
    }
}
