<?php

namespace MedianetDev\PConnector\Tests;

use Orchestra\Testbench\TestCase;
use MedianetDev\PConnector\PConnectorServiceProvider;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [PConnectorServiceProvider::class];
    }

    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
