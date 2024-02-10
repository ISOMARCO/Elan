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
        \Blade::directive('Date_To_String', function ($Date, $Explode = ' ') {
            $date = explode(" ", $Date);
            $time = $date[1];
            $dateFormat = explode('-', $date[0]);
            $months = [
                '01' => 'Yanvar',
                '02' => 'Fevral',
                '03' => 'Mart',
                '04' => 'Aprel',
                '05' => 'May',
                '06' => 'İyun',
                '07' => 'İyul',
                '08' => 'Avqust',
                '09' => 'Sentyabr',
                '10' => 'Oktyabr',
                '11' => 'Noyabr',
                '12' => 'Dekabr'
            ];
            $return = $dateFormat[2]." ".$months[$dateFormat[1]]." ".$dateFormat[0].$Explode.$time;
            return "<?php echo $return; ?>";
        });
    }
}
