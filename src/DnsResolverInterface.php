<?php

namespace ArtemBaranovskyi\DnsLookup;

use ArtemBaranovskyi\DnsLookup\Collections\DnsRecordCollection;

interface DnsResolverInterface
{
    /**
     * @param string $domain
     * @return DnsRecordCollection
     */
    public function resolve(string $domain): bool | DnsRecordCollection | array | string;
}
