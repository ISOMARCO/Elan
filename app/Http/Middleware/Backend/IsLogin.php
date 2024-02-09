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
        if(!Session::has('id') && ($request->route()->getName() !== 'Logout' || $request->route()->getName() !== 'Login'))
        {
            echo "burdayam";
            redirect(url('/admin/login'));
        }
        else
        {
            echo "burda deyilem";
        }
        if(Session::has('id') && $request->route()->getName() === 'Login')
        {
            redirect(url('/admin/home'));
        }
        return $next($request);
    }
}
