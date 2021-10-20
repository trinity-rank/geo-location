<?php

namespace Trinityrank\GeoLocation;

use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;

class GeoLocationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ ."/database/migrations/2021_10_20_115318_add_geolocation_columns_to_operaters_table.php" =>
                'database/migrations/2021_10_20_115318_add_geolocation_columns_to_operaters_table.php',
            ], "geolocation-migration");
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
