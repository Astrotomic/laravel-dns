<?php

namespace Tests;

use Astrotomic\Dns\Domain;
use Illuminate\Support\Str;
use Tests\Models\Team;

final class DomainCastTest extends TestCase
{
    public function test_it_casts_empty_raw_value_to_null(): void
    {
        foreach ([null, ''] as $domain) {
            $this->assertNull(Team::new(['domain' => $domain])->domain);
        }
    }

    public function test_it_casts_raw_value_to_domain_instance(): void
    {
        foreach ([
            'https://astrotomic.info',
            Str::of('https://astrotomic.info'),
            Domain::make('https://astrotomic.info'),
        ] as $domain) {
            $value = Team::new(['domain' => $domain])->domain;

            $this->assertInstanceOf(Domain::class, $value);
            $this->assertSame('astrotomic.info', (string) $value);
        }
    }

    public function test_it_casts_empty_value_to_null(): void
    {
        foreach ([null, ''] as $domain) {
            $team = Team::new();
            $team->domain = $domain;

            $this->assertNull($team->getAttributes()['domain']);
        }
    }

    public function test_it_casts_value_to_sanitized_string(): void
    {
        foreach ([
            'https://astrotomic.info',
            Str::of('https://astrotomic.info'),
            Domain::make('https://astrotomic.info'),
        ] as $domain) {
            $team = Team::new();
            $team->domain = $domain;

            $this->assertSame('astrotomic.info', $team->getAttributes()['domain']);
        }
    }
}
