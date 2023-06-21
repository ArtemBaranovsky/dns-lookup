<?php

namespace ArtemBaranovskyi\DnsLookup\Facades;

use Illuminate\Support\Facades\Facade;

class DnsLookupFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'dnslookup';
    }
}
