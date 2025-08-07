<?php

namespace Tests;

use Marcionunes\PenumType\PenumTypeServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        // additional setup
    }

    protected function getPackageProviders($app)
    {
        return [
            PenumTypeServiceProvider::class,
        ];
    }
}
