<?php

namespace Tests\Models;

use Astrotomic\Dns\Domain;
use Illuminate\Database\Eloquent\Model;

/**
 * @property \Astrotomic\Dns\Domain|null $domain
 */
class Team extends Model
{
    protected $fillable = ['domain'];

    protected $casts = [
        'domain' => Domain::class,
    ];

    public static function new(array $attributes = []): self
    {
        return tap(new static(), fn (Team $team) => $team->setRawAttributes($attributes));
    }
}
