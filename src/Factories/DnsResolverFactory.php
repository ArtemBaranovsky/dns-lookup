<?php

namespace ArtemBaranovskyi\DnsLookup\Factories;

use ArtemBaranovskyi\DnsLookup\DnsResolver;
use ArtemBaranovskyi\DnsLookup\DnsResolverInterface;
use ArtemBaranovskyi\DnsLookup\Formatters\OutputFormatterInterface;

class DnsResolverFactory implements DnsResolverFactoryInterface
{
    /**
     * @param OutputFormatterInterface $outputFormatter
     * @return DnsResolverInterface
     */
    public function createDnsResolver(OutputFormatterInterface $outputFormatter): DnsResolverInterface
    {
        return new DnsResolver($outputFormatter);
    }
}
