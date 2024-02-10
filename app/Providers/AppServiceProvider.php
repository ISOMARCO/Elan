<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Blade::directive('Date_To_String', function ($expression) {
            return "<?php echo \\Carbon\\Carbon::parse({$expression})->format('Y-m-d H:i'); ?>";
        });
    }
}
