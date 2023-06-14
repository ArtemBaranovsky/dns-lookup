<?php

namespace ArtemBaranovskyi\DnsLookup\Formatters;

use ArtemBaranovskyi\DnsLookup\Collections\DnsRecordCollection;

interface OutputFormatterInterface
{
    /**
     * @param DnsRecordCollection $records
     * @param string $format
     * @return bool|DnsRecordCollection|array|string
     */
    public function format(DnsRecordCollection $records, string $format): bool | DnsRecordCollection | array | string;
}
