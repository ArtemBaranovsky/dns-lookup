<?php

namespace ArtemBaranovskyi\DnsLookup\Tests;

use PHPUnit\Framework\TestCase;
use ArtemBaranovskyi\DnsLookup\DnsLookup;

class DnsLookupTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function testGetDnsRecords()
    {
        $dnsLookup = new DnsLookup();
        $result = $dnsLookup->getDnsRecords("google.com");

        $this->assertIsArray($result);
    }

    /**
     * @throws \Exception
     */
    public function testGetDnsRecordsCollection()
    {
        $dnsLookup = new DnsLookup();
        $result = $dnsLookup->getDnsRecords("google.com", 'collection');

        $this->assertIsArray($result->toArray());
        $this->assertEquals(gettype($result), 'object');
    }
}
