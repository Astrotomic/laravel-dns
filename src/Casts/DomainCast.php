<?php

namespace Astrotomic\Dns\Casts;

use Astrotomic\Dns\Domain;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class DomainCast implements CastsAttributes
{
    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string $key
     * @param null|string|\Stringable $value
     * @param array $attributes
     * @return \Astrotomic\Dns\Domain|null
     */
    public function get($model, string $key, $value, array $attributes): ?Domain
    {
        if(empty($value)) {
            return null;
        }

        return new Domain($value);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string $key
     * @param null|string|\Stringable $value
     * @param array $attributes
     * @return string|null
     */
    public function set($model, string $key, $value, array $attributes): ?string
    {
        if (empty(strval($value))) {
            return null;
        }

        return (string) new Domain(strval($value));
    }
}