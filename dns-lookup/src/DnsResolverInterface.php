<?php

namespace ArtemBaranovskyi\DnsLookup;

use ArtemBaranovskyi\DnsLookup\Collections\DnsRecordCollection;

interface DnsResolverInterface
{
    public function resolve(string $domain): DnsRecordCollection;
}
