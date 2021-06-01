<?php

use Astrotomic\Dns\Domain;
use Illuminate\Support\Str;
use Tests\Models\Team;

it('it casts empty raw value to null', function ($domain) {
    expect(Team::new(['domain' => $domain])->domain)->toBeNull();
})->with([
    'null' => null,
    'empty' => '',
]);

it('it casts raw value to domain instance', function ($domain) {
    expect(Team::new(['domain' => $domain])->domain)
        ->toBeInstanceOf(Domain::class)
        ->toEqual('astrotomic.info');
})->with([
    'string' => 'https://astrotomic.info',
    'stringable' => Str::of('https://astrotomic.info'),
    'domain' => Domain::make('https://astrotomic.info'),
]);

it('it casts empty value to null', function ($domain) {
    $team = Team::new();
    $team->domain = $domain;
    expect($team->getAttributes()['domain'])->toBeNull();
})->with([
    'null' => null,
    'empty' => '',
]);

it('it casts value to sanitized string', function ($domain) {
    $team = Team::new();
    $team->domain = $domain;
    expect($team->getAttributes()['domain'])
        ->toBeString()
        ->toEqual('astrotomic.info');
})->with([
    'string' => 'https://astrotomic.info',
    'stringable' => Str::of('https://astrotomic.info'),
    'domain' => Domain::make('https://astrotomic.info'),
]);
