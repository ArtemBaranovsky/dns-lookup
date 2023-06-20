<?php

namespace ArtemBaranovskyi\DnsLookup\Formatters;

use ArtemBaranovskyi\DnsLookup\Collections\DnsRecordCollection;
use Psr\Log\LoggerInterface;

interface OutputFormatterInterface
{
    /**
     * @param DnsRecordCollection $records
     * @param string $format
     * @return bool|DnsRecordCollection|array|string
     */
    public function format(DnsRecordCollection $records): bool | DnsRecordCollection | array | string;
}
