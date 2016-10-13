<?php

namespace Hirealite\LaravelTomTom\Tests;

use Hirealite\LaravelTomTom\TomTom;
use Hirealite\LaravelTomTom\TomTomServiceProvider;
use Orchestra\Testbench\TestCase as Testbench;

class TestCase extends Testbench
{
    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            TomTomServiceProvider::class,
        ];
    }

    /**
     * @return TomTom
     */
    protected function getApi()
    {
        return $this->app['tomtom'];
    }
}