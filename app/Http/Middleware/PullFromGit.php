<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PullFromGit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        shell_exec('git pull https://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@github.com/ISOMARCO/Elan.git');
        return $next($request);
    }
}
