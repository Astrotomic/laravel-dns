<?php

namespace Tests;

use Astrotomic\Dns\Rules\DnsRecordExists;
use Spatie\Dns\Records\TXT;

final class DnsRecordExistsTest extends TestCase
{
    public function test_validates_that_any_record_exists(): void
    {
        $this->assertTrue(
            DnsRecordExists::make()
                ->passes('', 'astrotomic.info')
        );
    }

    public function test_validates_that_url_is_reachable(): void
    {
        $this->assertTrue(
            DnsRecordExists::make()
                ->expect(DNS_A | DNS_AAAA | DNS_CNAME)
                ->passes('', 'https://astrotomic.info')
        );
    }

    public function test_validates_that_address_is_mailable(): void
    {
        $this->assertTrue(
            DnsRecordExists::make()
                ->expect(DNS_MX)
                ->expect(DNS_TXT, fn (TXT $record): bool => str_starts_with($record->txt(), 'v=spf1 '))
                ->passes('', 'dns@astrotomic.info')
        );
    }

    public function test_fails_when_domain_does_not_exist(): void
    {
        $this->assertFalse(
            DnsRecordExists::make()
                ->passes('', 'foo.astrotomic')
        );
    }

    public function test_fails_when_record_type_is_not_present(): void
    {
        $this->assertFalse(
            DnsRecordExists::make()
                ->expect(DNS_CNAME)
                ->passes('', 'astrotomic.info')
        );
    }

    public function test_fails_when_expectation_is_not_fulfilled(): void
    {
        $this->assertFalse(
            DnsRecordExists::make()
                ->expect(DNS_ALL, fn () => false)
                ->passes('', 'astrotomic.info')
        );
    }

    public function test_fails_when_value_is_not_a_string(): void
    {
        $this->assertFalse(
            DnsRecordExists::make()->passes('', ['astrotomic.info'])
        );
    }

    public function test_fails_when_domain_is_empty(): void
    {
        $this->assertFalse(
            DnsRecordExists::make()->passes('', '')
        );
    }
}
