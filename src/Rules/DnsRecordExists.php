<?php

namespace Astrotomic\Dns\Rules;

use Astrotomic\Dns\Dns;
use Astrotomic\Dns\Domain;
use Closure;
use Illuminate\Container\Container;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Lang;

class DnsRecordExists implements Rule
{
    /** @var array<int|string, \Closure> */
    protected array $expectations = [];

    public static function make(): static
    {
        return Container::getInstance()->make(static::class);
    }

    public function __construct(protected Dns $dns)
    {
    }

    public function expect(int|string $type, ?Closure $expectation = null): static
    {
        $this->expectations[$type] = $expectation ?? fn() => true;

        return $this;
    }

    public function passes($attribute, $value): bool
    {
        if (!is_string($value)) {
            return false;
        }

        $domain = Domain::parse($value);

        if ($domain === null) {
            return false;
        }

        if (empty($this->expectations)) {
            return $this->dns->records($domain)->isNotEmpty();
        }

        return collect($this->expectations)
            ->every(fn (Closure $expectation, int|string $type): bool => $this->dns->records($domain, $type)
                ->filter($expectation)
                ->isNotEmpty()
            );
    }

    public function message(): string
    {
        return Lang::get('validation.dns');
    }
}