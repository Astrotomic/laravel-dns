<?php

namespace Tests;

use Astrotomic\Dns\DnsServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [DnsServiceProvider::class];
    }
}
