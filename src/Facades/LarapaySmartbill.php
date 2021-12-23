<?php

namespace IdeaToCode\LarapaySmartbill\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \IdeaToCode\LarapaySmartbill\LarapaySmartbill
 */
class LarapaySmartbill extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'larapay-smartbill';
    }
}
