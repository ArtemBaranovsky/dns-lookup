<?php

namespace ArtemBaranovskyi\DnsLookup\Exceptions;

use Exception;
use Throwable;

class DnsQueryException extends Exception
{
    public function __construct($message = "DNS query failed", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
