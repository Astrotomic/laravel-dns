<?php

namespace Astrotomic\Dns;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;
use Spatie\Dns\Dns as SpatieDns;
use Spatie\Dns\Support\Factory;
use Spatie\Dns\Support\Types;

class DnsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(Types::class);

        $this->app->singleton(Factory::class);

        $this->app->singleton(Dns::class, static function (Container $app): Dns {
            return new Dns(
                $app->make(Types::class),
                $app->make(Factory::class)
            );
        });
        $this->app->alias(Dns::class, SpatieDns::class);
    }
}
