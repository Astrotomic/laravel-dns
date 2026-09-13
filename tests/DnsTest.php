<?php

namespace Tests;

use Astrotomic\Dns\Facades\Dns;
use Illuminate\Support\Collection;
use Spatie\Dns\Records\Record;

final class DnsTest extends TestCase
{
    public function test_it_returns_a_collection_of_records(): void
    {
        $records = Dns::records('https://astrotomic.info');

        $this->assertInstanceOf(Collection::class, $records);

        foreach ($records as $record) {
            $this->assertInstanceOf(Record::class, $record);
        }
    }
}
