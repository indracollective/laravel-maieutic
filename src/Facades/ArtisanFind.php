<?php

namespace Indra\ArtisanFind\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Indra\ArtisanFind\ArtisanFind
 */
class ArtisanFind extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Indra\ArtisanFind\ArtisanFind::class;
    }
}
