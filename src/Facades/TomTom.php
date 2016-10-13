<?php namespace Hirealite\LaravelTomTom\Facades;

use \Illuminate\Support\Facades\Facade;

class TomTom extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'tomtom';
    }
}
