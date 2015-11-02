<?php namespace Hirealite\LaravelTomTom;

use \Illuminate\Support\Facades\Facade;

class TomTomFacade extends Facade
{
	protected static function getFacadeAccessor()
	{
		return 'tomtom';
	}
}
