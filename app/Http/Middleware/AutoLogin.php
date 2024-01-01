<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class AutoLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        echo $request->hasCookie(encrypt('Remember_Me_Token'))." token";
        if(!Session::has('id') && Cookie::has(encrypt('Remember_Me_Token')))
        {
            echo "Auto login olmalidi";
        }
        return $next($request);
    }
}
