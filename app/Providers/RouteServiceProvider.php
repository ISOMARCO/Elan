<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';
    protected $namespace = "\\App\\Http\\Controllers";
    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));

            Route::middleware('authentication')
                ->namespace($this->namespace."\Frontend")
                ->group(base_path('routes/Frontend/Authentication/authentication.php'));

            Route::middleware('user')
                ->namespace($this->namespace."\Frontend")
                ->group(base_path('routes/Frontend/User/user.php'));

            Route::middleware('backend_authentication')
                ->prefix('admin')
                ->namespace($this->namespace."\Backend")
                ->group(base_path('routes/Backend/Authentication/authentication.php'));

            Route::middleware('backend_users')
                ->prefix('admin')
                ->namespace($this->namespace."\Backend")
                ->group(base_path('routes/Backend/Users/users.php'));
        });
    }
}
