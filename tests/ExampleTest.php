<?php

namespace MedianetDev\PConnector\Tests;

use MedianetDev\PConnector\PConnectorServiceProvider;
use Orchestra\Testbench\TestCase;

class ExampleTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [PConnectorServiceProvider::class];
    }

    public function test_true_is_true()
    {
        $this->assertTrue(true);
    }
}
