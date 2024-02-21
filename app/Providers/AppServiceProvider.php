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
        $this->loadJsonTranslationsFromModules();
        \Blade::directive('Date_To_String', function ($expression) {
            return "<?php echo \\Carbon\\Carbon::parse({$expression})->isoFormat('LL LT'); ?>";
        });
    }

    protected function loadJsonTranslationsFromModules()
    {
        $directories = glob(resource_path('lang/*'), GLOB_ONLYDIR);

        foreach ($directories as $directory) {
            $moduleName = basename($directory);
            $jsonPath = resource_path("lang/$moduleName/" . app()->getLocale() . '.json');

            if (File::exists($jsonPath)) {
                $translations = json_decode(file_get_contents($jsonPath), true);
                foreach ($translations as $key => $value) {
                    $this->app['translator']->addLines($key, $value, $moduleName);
                }
            }
        }
    }
}
