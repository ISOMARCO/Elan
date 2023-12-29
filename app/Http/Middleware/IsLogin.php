<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;

class IsLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Session::has('id') && $request->route()->getName() !== 'Logout')
        {
            return redirect()->back();
        }
        if(!Session::has('id') && Cookie::has(encrypt('Remember_Me_Token')))
        {
            echo "var";
        }
        echo "var";
        return $next($request);
    }
}
