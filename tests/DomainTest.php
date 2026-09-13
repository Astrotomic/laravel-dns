<?php

namespace Tests;

use Astrotomic\Dns\Domain;
use Illuminate\Support\Str;
use Spatie\Dns\Exceptions\InvalidArgument;

final class DomainTest extends TestCase
{
    public function test_it_is_makeable(): void
    {
        $domain = Domain::make('https://astrotomic.info');

        $this->assertInstanceOf(Domain::class, $domain);
        $this->assertSame('astrotomic.info', (string) $domain);
    }

    public function test_it_parses_domain(): void
    {
        foreach ([
            'https://astrotomic.info',
            Str::of('https://astrotomic.info'),
            Domain::make('https://astrotomic.info'),
        ] as $domain) {
            $this->assertSame('astrotomic.info', Domain::parse($domain));
        }
    }

    public function test_it_can_parse_from_empty(): void
    {
        foreach ([null, ''] as $domain) {
            $this->assertNull(Domain::parse($domain));
        }
    }

    public function test_it_is_json_serializable(): void
    {
        $this->assertSame('"astrotomic.info"', json_encode(Domain::make('https://astrotomic.info')));
    }

    public function test_it_throws_exception_for_invalid_domain(): void
    {
        $this->expectException(InvalidArgument::class);

        Domain::make('');
    }
}
