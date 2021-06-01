# Laravel DNS

[![Latest Version](http://img.shields.io/packagist/v/astrotomic/laravel-dns.svg?label=Release&style=for-the-badge)](https://packagist.org/packages/astrotomic/laravel-dns)
[![MIT License](https://img.shields.io/github/license/Astrotomic/laravel-dns.svg?label=License&color=blue&style=for-the-badge)](https://github.com/Astrotomic/laravel-dns/blob/master/LICENSE)
[![Offset Earth](https://img.shields.io/badge/Treeware-%F0%9F%8C%B3-green?style=for-the-badge)](https://plant.treeware.earth/Astrotomic/laravel-dns)
[![Larabelles](https://img.shields.io/badge/Larabelles-%F0%9F%A6%84-lightpink?style=for-the-badge)](https://www.larabelles.com/)

[![GitHub Workflow Status](https://img.shields.io/github/workflow/status/Astrotomic/laravel-dns/pest?style=flat-square&logoColor=white&logo=github&label=Tests)](https://github.com/Astrotomic/laravel-dns/actions?query=workflow%3Apest)
[![GitHub Workflow Status](https://img.shields.io/github/workflow/status/Astrotomic/laravel-dns/php-cs-fixer?style=flat-square&logoColor=white&logo=github&label=Code+Style)](https://github.com/Astrotomic/laravel-dns/actions?query=workflow%3Aphp-cs-fixer)
[![Total Downloads](https://img.shields.io/packagist/dt/astrotomic/laravel-dns.svg?label=Downloads&style=flat-square)](https://packagist.org/packages/astrotomic/laravel-dns)

## Installation

```bash
composer require astrotomic/laravel-dns
```

## Usage

```php
use Astrotomic\Dns\Facades\Dns;

/** @var \Illuminate\Support\Collection $records */
$records = Dns::records('astrotomic.info', DNS_A);
```

```php
use Astrotomic\Dns\Rules\DnsRecordExists;
use Spatie\Dns\Records\A;
use Spatie\Dns\Records\TXT;

return [
    'url' => [
        'required',
        'string',
        'url',
        // verify that domain of entered url
        // has any A, AAAA or CNAME record
        // and a TXT record with the users token
        DnsRecordExists::make()
            ->expect(DNS_A|DNS_AAAA|DNS_CNAME)
            ->expect(DNS_TXT, fn(TXT $record): bool => $record->txt() === 'token='.$this->user()->public_token),
    ],
    'email' => [
        'required',
        'string',
        'email',
        // verify that domain of entered email
        // has any MX record
        // and SPF setup
        DnsRecordExists::make()
            ->expect(DNS_MX)
            ->expect(DNS_TXT, fn(TXT $record): bool => str_starts_with($record->txt(), 'v=spf1 ')),
    ],
    'domain' => [
        'required',
        'string',
        // verify that entered domain
        // has an A record
        // pointing to our IP-address
        DnsRecordExists::make()
            ->expect(DNS_A, fn(A $record): bool => $record->ip() === '127.0.0.1'),
    ],
    'something' => [
        'required',
        'string',
        // verify that value is something with DNS
        DnsRecordExists::make(),
    ],
];
```

```php
use Astrotomic\Dns\Domain;

protected $casts = [
    'domain' => Domain::class,
];
```

```php
use Astrotomic\Dns\Domain;

/** @var \Astrotomic\Dns\Domain $domain */
$domain = Domain::make('dns@astrotomic.info');

/** @var string|null $domain */
$domain = Domain::parse('dns@astrotomic.info');
```