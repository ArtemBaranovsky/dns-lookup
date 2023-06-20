<?php

namespace ArtemBaranovskyi\DnsLookup\Factories;

use ArtemBaranovskyi\DnsLookup\DnsResolverInterface;
use ArtemBaranovskyi\DnsLookup\Formatters\OutputFormatterInterface;

interface DnsResolverFactoryInterface
{
    /**
     * @param OutputFormatterInterface $outputFormatter
     * @return DnsResolverInterface
     */
    public function createDnsResolver(OutputFormatterInterface $outputFormatter): DnsResolverInterface;
}
