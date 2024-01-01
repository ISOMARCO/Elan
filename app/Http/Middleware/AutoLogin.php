<?php

namespace App\Http\Middleware;

use App\Models\Authentication\Users;
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
        echo Cookie::get('Remember_Me');
        if(!Session::has('id') && Cookie::has('Remember_Me'))
        {
            $users = new Users();
            $users->Login_With_Token(Cookie::get('Remember_Me'));
        }
        return $next($request);
    }
}
