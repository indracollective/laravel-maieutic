<?php

namespace Indra\LaravelMaieutic\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Indra\LaravelMaieutic\LaravelMaieutic
 */
class LaravelMaieutic extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Indra\LaravelMaieutic\LaravelMaieutic::class;
    }
}
