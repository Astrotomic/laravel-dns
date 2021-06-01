<?php

use Astrotomic\Dns\Domain;
use Illuminate\Support\Str;
use Spatie\Dns\Exceptions\InvalidArgument;

it('is makeable', function () {
    expect(Domain::make('https://astrotomic.info'))
        ->toBeInstanceOf(Domain::class)
        ->toEqual('astrotomic.info');
});

it('parses domain', function ($domain) {
    expect(Domain::parse($domain))
        ->toBeString()
        ->toEqual('astrotomic.info');
})->with([
    'string' => 'https://astrotomic.info',
    'stringable' => Str::of('https://astrotomic.info'),
    'domain' => Domain::make('https://astrotomic.info'),
]);

it('can parse from empty', function ($domain) {
    expect(Domain::parse($domain))->toBeNull();
})->with([
    'null' => null,
    'empty' => '',
]);

it('is JSON serializable', function () {
    expect(json_encode(Domain::make('https://astrotomic.info')))
        ->toBeString()
        ->toEqual('"astrotomic.info"');
});

it('throws exception for invalid domain', function () {
    Domain::make('');
})->expectException(InvalidArgument::class);

