<?php

namespace HydraStorage\HydraStorage\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \HydraStorage\HydraStorage\HydraStorage
 */
class HydraStorage extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \HydraStorage\HydraStorage\HydraStorage::class;
    }
}
