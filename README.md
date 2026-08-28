# Laravel DNS

[![Latest Version](http://img.shields.io/packagist/v/astrotomic/laravel-dns.svg?label=Release&style=for-the-badge)](https://packagist.org/packages/astrotomic/laravel-dns)
[![MIT License](https://img.shields.io/github/license/Astrotomic/laravel-dns.svg?label=License&color=blue&style=for-the-badge)](https://github.com/Astrotomic/laravel-dns/blob/master/LICENSE)
[![Offset Earth](https://img.shields.io/badge/Treeware-%F0%9F%8C%B3-green?style=for-the-badge)](https://plant.treeware.earth/Astrotomic/laravel-dns)
[![Larabelles](https://img.shields.io/badge/Larabelles-%F0%9F%A6%84-lightpink?style=for-the-badge)](https://www.larabelles.com/)

![](https://img.shields.io/badge/PHP-^8.1-777BB4?style=for-the-badge&logo=php&logoColor=white)
![](https://img.shields.io/badge/Laravel-9--13-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)

[![GitHub Workflow Status](https://img.shields.io/github/actions/workflow/status/Astrotomic/laravel-dns/phpunit.yml?branch=main&style=flat-square&logoColor=white&logo=github&label=Tests)](https://github.com/Astrotomic/laravel-dns/actions/workflows/phpunit.yml)
[![GitHub Workflow Status](https://img.shields.io/github/actions/workflow/status/Astrotomic/laravel-dns/php-cs-fixer.yml?branch=main&style=flat-square&logoColor=white&logo=github&label=Code+Style)](https://github.com/Astrotomic/laravel-dns/actions/workflows/php-cs-fixer.yml)
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
        DnsRecordExists::make(),
    ],
];
```

## Domain value object

```php
use Astrotomic\Dns\Domain;

$domain = Domain::make('https://astrotomic.info/foo/bar');
$domain->getDomain(); // astrotomic.info
```

The domain value object can also be used as an Eloquent cast.

```php
use Astrotomic\Dns\Domain;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $casts = [
        'domain' => Domain::class,
    ];
}
```

## Testing

```bash
composer test
```

## Contributing

Please see [CONTRIBUTING](https://github.com/Astrotomic/.github/blob/master/CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email security@astrotomic.info instead of using the issue tracker.

## Credits

- [Tom Herrmann](https://github.com/Gummibeer)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.

## Treeware

You're free to use this package, but if it makes it to your production environment you are required to buy the world a tree.

It's now a requirement to contribute to my climate action fund on [Ecologi](https://ecologi.com/astrotomic).

This way you can be sure that you actually plant trees and my local environment is not affected by it.

## Larabelles

If you want to show your support for women in tech, I strongly encourage you to buy a [Larabelles](https://www.larabelles.com/) product.
