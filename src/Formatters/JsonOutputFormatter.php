<?php

namespace ArtemBaranovskyi\DnsLookup\Formatters;

use ArtemBaranovskyi\DnsLookup\Collections\DnsRecordCollection;

class JsonOutputFormatter implements OutputFormatterInterface
{
    /**
     * @param DnsRecordCollection $records
     * @param string $format
     * @return bool|string
     */
    public function format(DnsRecordCollection $records): bool | string
    {
        return json_encode($records->toArray());
    }
}
