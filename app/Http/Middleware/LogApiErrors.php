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
        $start = microtime(true);
        $response = $next($request);
        $end = microtime(true);
        $duration = $end - $start;
        $duration = number_format($duration, 2);
        $fileError = fopen('api.log','a');
        $time = now();
        fwrite($fileError, "[$time] | URL : ". $request->url() ." | ".$response->getStatusCode()." | Duration : ".$duration."ms \n");
        fclose($fileError);

        return $response;
    }
}
