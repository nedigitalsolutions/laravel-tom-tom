<?php namespace Hirealite\LaravelTomTom;

use Illuminate\Support\ServiceProvider;

class TomTomServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/tomtom.php' => config_path('tomtom.php'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('tomtom', TomTom::class);
    }
}
