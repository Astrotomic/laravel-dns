<?php

namespace Astrotomic\Dns;

use Illuminate\Support\Collection;
use Illuminate\Support\Traits\Macroable;
use Spatie\Dns\Dns as SpatieDns;
use Stringable;

class Dns extends SpatieDns
{
    use Macroable;

    public function records(
        string | Stringable $search,
        int | string | array $types = DNS_ALL
    ): Collection
    {
        return collect($this->getRecords($search, $types));
    }
}