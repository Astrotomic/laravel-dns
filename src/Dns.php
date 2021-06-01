<?php

namespace Astrotomic\Dns;

use Illuminate\Support\Collection;
use Spatie\Dns\Dns as SpatieDns;
use Spatie\Dns\Support\Domain;
use Stringable;

class Dns extends SpatieDns
{
    public function records(
        string | Domain | Stringable $search,
        int | string | array $types = DNS_ALL
    ): Collection
    {
        return collect($this->getRecords($search, $types));
    }
}