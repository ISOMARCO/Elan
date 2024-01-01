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
        echo Cookie::get('eyJpdiI6InA5bjlsQTFxNWVXMXFBSWI4TDNoMFE9PSIsInZhbHVlIjoiMkhFSnRpOFE0YW0yRGljOC9hUmxmYjBDaUkxR3RWdzI4WWJERHBVbTd5OD0iLCJtYWMiOiI0YTg2NWFiMDEyM2E1Yjk4ODViZWUzZjEzZjRiZDYzM2Q2ZDNhODdmZWU0ZjZkZjMwN2JlOWQ0MTYzM2I4YTExIiwidGFnIjoiIn0%3D');
        if(!Session::has('id') && Cookie::has(encrypt('Remember_Me_Token')))
        {
            echo "Auto login olmalidi";
        }
        return $next($request);
    }
}
