<?php

namespace Astrotomic\Dns;

use Astrotomic\Dns\Casts\DomainCast;
use Illuminate\Contracts\Database\Eloquent\Castable;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Traits\Macroable;
use JsonSerializable;
use Spatie\Dns\Support\Domain as SpatieDomain;
use Stringable;

class Domain extends SpatieDomain implements Castable, JsonSerializable, Jsonable
{
    use Macroable;

    public static function make(string|Stringable $domain): static
    {
        return new static($domain);
    }

    public static function parse(string|Stringable $domain): string
    {
        return new static($domain);
    }

    public static function castUsing(array $arguments): CastsAttributes
    {
        return new DomainCast();
    }

    public function toJson($options = 0): string
    {
        return json_encode($this->jsonSerialize(), $options);
    }

    public function jsonSerialize(): string
    {
        return $this->domain;
    }
}