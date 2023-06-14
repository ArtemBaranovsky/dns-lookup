<?php

namespace ArtemBaranovskyi\DnsLookup\Formatters;

use ArtemBaranovskyi\DnsLookup\Collections\DnsRecordCollection;

class DnsRecordCollectionOutputFormatter implements OutputFormatterInterface
{
    /**
     * @param DnsRecordCollection $records
     * @param string $format
     * @return DnsRecordCollection
     */
    public function format(DnsRecordCollection $records, string $format): DnsRecordCollection
    {
        return $records;
    }
}
