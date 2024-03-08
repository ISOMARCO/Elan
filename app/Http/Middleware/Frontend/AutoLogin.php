<?php

namespace App\Http\Middleware\Frontend;

use App\Models\Frontend\Authentication\Users;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class AutoLogin
{
    public function handle(Request $request, Closure $next): Response
    {
        if(!Session::has('id') && Cookie::has('Remember_Me') && $request->route()->getName() !== 'Frontend.Logout')
        {
            $users = new Users();
            $users->Login_With_Token(Cookie::get('Remember_Me'));
        }
        return $next($request);
    }
}
