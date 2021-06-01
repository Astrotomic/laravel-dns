<?php

namespace Astrotomic\Dns;

use Astrotomic\Dns\Casts\DomainCast;
use Illuminate\Contracts\Database\Eloquent\Castable;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Support\Traits\Macroable;
use JsonSerializable;
use Spatie\Dns\Exceptions\InvalidArgument;
use Spatie\Dns\Support\Domain as SpatieDomain;
use Stringable;

class Domain extends SpatieDomain implements Castable, JsonSerializable
{
    use Macroable;

    /**
     * @param string|\Stringable $domain
     * @return static
     * @throws \Spatie\Dns\Exceptions\InvalidArgument
     */
    public static function make(string|Stringable $domain): static
    {
        return new static($domain);
    }

    public static function parse(string|Stringable|null $domain): ?string
    {
        if (empty($domain)) {
            return null;
        }

        try {
            return static::make($domain);
        } catch (InvalidArgument) {
            return null;
        }
    }

    public static function castUsing(array $arguments): CastsAttributes
    {
        return new DomainCast();
    }

    public function jsonSerialize(): string
    {
        return $this->domain;
    }
}