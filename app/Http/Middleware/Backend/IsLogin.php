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
        print_r(Session::all());
        if(!Session::has('id') && $request->route()->getName() != 'Backend_Login' && $request->route()->getName() != 'Backend_LoginAction')
        {
            return redirect('/admin/login');
        }
        if(Session::has('id') && $request->route()->getName() == 'Backend_Login')
        {
            return redirect('admin/');
        }
        return $next($request);
    }
}
