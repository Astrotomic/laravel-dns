<?php

use Astrotomic\Dns\Rules\DnsRecordExists;
use Spatie\Dns\Records\TXT;

it('validates that any record exists', function () {
    expect(
        DnsRecordExists::make()
            ->passes('', 'astrotomic.info')
    )->toBeTrue();
});

it('validates that URL is reachable', function () {
    expect(
        DnsRecordExists::make()
            ->expect(DNS_A | DNS_AAAA | DNS_CNAME)
            ->passes('', 'https://astrotomic.info')
    )->toBeTrue();
});

it('validates that address is mailable', function () {
    expect(
        DnsRecordExists::make()
            ->expect(DNS_MX)
            ->expect(DNS_TXT, fn (TXT $record): bool => str_starts_with($record->txt(), 'v=spf1 '))
            ->passes('', 'dns@astrotomic.info')
    )->toBeTrue();
});

it('fails when no record exists', function () {
    expect(
        DnsRecordExists::make()
            ->passes('', 'foo.astrotomic.info')
    )->toBeFalse();
});

it('fails when record type is not present', function () {
    expect(
        DnsRecordExists::make()
            ->expect(DNS_CNAME)
            ->passes('', 'astrotomic.info')
    )->toBeFalse();
});

it('fails when expectation is not fulfilled', function () {
    expect(
        DnsRecordExists::make()
            ->expect(DNS_ALL, fn () => false)
            ->passes('', 'astrotomic.info')
    )->toBeFalse();
});

it('fails when value is not a string', function () {
    expect(
        DnsRecordExists::make()->passes('', ['astrotomic.info'])
    )->toBeFalse();
});

it('fails when domain is empty', function () {
    expect(
        DnsRecordExists::make()->passes('', '')
    )->toBeFalse();
});
