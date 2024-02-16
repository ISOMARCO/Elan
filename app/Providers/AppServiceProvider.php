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
            return "<?php echo \\Carbon\\Carbon::parse({$expression})->isoFormat('LL LT'); ?>";
        });

        \Blade::directive('Border_Random_Color', function($number = 1){
            $red = rand(0, 255);
            $green = rand(0, 255);
            $blue = rand(0, 255);
            return "<?php echo sprintf(\"#%02x%02x%02x\", $red, $green, $blue);?>";
        });
    }
}
