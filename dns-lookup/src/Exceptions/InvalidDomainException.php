<?php

namespace ArtemBaranovskyi\DnsLookup\Exceptions;

use Exception;
use Throwable;

class InvalidDomainException extends Exception
{
    /**
     * @param $message
     * @param $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "Provided domain name is incorrect", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
