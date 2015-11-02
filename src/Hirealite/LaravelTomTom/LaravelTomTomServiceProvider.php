<?php namespace Hirealite\LaravelTomTom;

use Illuminate\Support\ServiceProvider;

class LaravelTomTomServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	//test
	public function boot()
	{
		$this->package('hirealite/laravel-tom-tom');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['tomtom'] = $this->app->share(function($app)
		{
			return TomTomAPI::getInstance();
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
