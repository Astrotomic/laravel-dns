<?php

namespace Astrotomic\Dns\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Astrotomic\Dns\Dns useNameserver(string $nameserver)
 * @method static \Illuminate\Support\Collection records(string|\Spatie\Dns\Support\Domain|\Stringable $search, int|string|array $types = DNS_ALL)
 */
class Dns extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Spatie\Dns\Dns::class;
    }
}
