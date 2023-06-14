<?php

namespace ArtemBaranovskyi\DnsLookup\Factories;

use ArtemBaranovskyi\DnsLookup\DnsResolverInterface;
use ArtemBaranovskyi\DnsLookup\Formatters\OutputFormatterInterface;

interface DnsResolverFactoryInterface
{
    public function createDnsResolver(OutputFormatterInterface $outputFormatter): DnsResolverInterface;
}
