<?php

namespace Hirealite\LaravelTomTom\Tests;

use Hirealite\LaravelTomTom\TomTom;

class TomTomTest extends TestCase
{
    /** @test */
    public function it_can_be_instantiated()
    {
        $this->assertInstanceOf(TomTom::class, $this->getApi());
    }
}