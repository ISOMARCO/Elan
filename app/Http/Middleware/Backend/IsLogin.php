<?php

namespace App\Http\Middleware\Backend;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;
class IsLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!Session::has('id') && $request->route()->getName() != 'Backend.Logout' && $request->route()->getName() != 'Backend.Login' && $request->route()->getName() != 'Backend.LoginAction')
        {
            return redirect()->route('Backend.Login');
        }
        if(Session::has('id') && $request->route()->getName() == 'Backend.Login')
        {
            return redirect()->route('Backend.Home');
        }
        return $next($request);
    }
}
