<?php

use Astrotomic\Dns\Facades\Dns;
use Illuminate\Support\Collection;
use Spatie\Dns\Records\Record;

it('is returns a collection of records', function () {
    expect(Dns::records('https://astrotomic.info'))
        ->toBeInstanceOf(Collection::class)
        ->each->toBeInstanceOf(Record::class);
});
