<?php

namespace App\Http\Middleware\Frontend;

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
        if(Session::has('id') && $request->route()->getName() != 'Frontend.Logout')
        {
            return redirect()->back();
        }
        return $next($request);
    }
}
