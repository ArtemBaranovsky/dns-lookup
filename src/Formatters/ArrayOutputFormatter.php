<?php

namespace ArtemBaranovskyi\DnsLookup\Formatters;

use ArtemBaranovskyi\DnsLookup\Collections\DnsRecordCollection;

class ArrayOutputFormatter implements OutputFormatterInterface
{
    /**
     * @param DnsRecordCollection $records
     * @param string $format
     * @return array
     */
    public function format(DnsRecordCollection $records): bool | array
    {
        return $records->toArray();
    }
}
