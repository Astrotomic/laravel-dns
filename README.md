# Laravel DNS

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
use Spatie\Dns\Records\A;use Spatie\Dns\Records\TXT;

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

$domain = (string) Domain::make('dns@astrotomic.info');
$domain = Domain::parse('dns@astrotomic.info');
// astrotomic.info
```