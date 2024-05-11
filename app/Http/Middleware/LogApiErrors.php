<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogApiErrors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        // Tangkap kesalahan jika responsenya bukan 2xx (sukses)
        if ($response->getStatusCode() >= 400 && $response->getStatusCode() <= 599) {
            $content = $response->getContent();
            $fileError = fopen('api.log','a');
            $time = now();
            fwrite($fileError, "[$time] | URL : ". $request->url() ." | ".$response->getStatusCode() ." | response : ".$content."\n\n--------------------------------------------------------------\n\n");
            fclose($fileError);
        }

        return $response;
    }
}
