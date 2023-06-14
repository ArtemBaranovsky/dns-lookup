<?php

use ArtemBaranovskyi\DnsLookup\DnsLookup;
use ArtemBaranovskyi\DnsLookup\DnsResolverInterface;
use ArtemBaranovskyi\DnsLookup\Factories\DnsResolverFactoryInterface;
use ArtemBaranovskyi\DnsLookup\Formatters\ArrayOutputFormatter;
use ArtemBaranovskyi\DnsLookup\Formatters\DnsRecordCollectionOutputFormatter;
use ArtemBaranovskyi\DnsLookup\Collections\DnsRecordCollection;
use Psr\Log\LoggerInterface;
use PHPUnit\Framework\TestCase;

class DnsLookupTest extends TestCase
{
    private DnsLookup $lookup;
    private DnsResolverFactoryInterface $resolverFactoryMock;
    private LoggerInterface $loggerMock;
    private DnsResolverInterface $dnsResolverMock;

    protected function setUp(): void
    {
        $this->resolverFactoryMock = $this->createMock(DnsResolverFactoryInterface::class);
        $this->loggerMock = $this->createMock(LoggerInterface::class);
        $this->dnsResolverMock = $this->createMock(DnsResolverInterface::class);

        $this->lookup = new DnsLookup(
            $this->resolverFactoryMock,
            $this->loggerMock
        );
    }

    public function testGetDnsRecordsReturnsArray()
    {
        $domain = 'example.com';
        $format = 'array';

        $dnsRecords = new DnsRecordCollection();

        $this->resolverFactoryMock->expects($this->once())
            ->method('createDnsResolver')
            ->with($this->isInstanceOf(ArrayOutputFormatter::class))
            ->willReturn($this->dnsResolverMock);

        $this->dnsResolverMock->expects($this->once())
            ->method('resolve')
            ->with($this->equalTo($domain))
            ->willReturn($dnsRecords);

        $result = $this->lookup->getDnsRecords($domain, $format);

        $this->assertEquals($dnsRecords->toArray(), $result);
    }

    public function testGetDnsRecordsReturnsCollection()
    {
        $domain = 'example.com';
        $format = 'collection';

        $dnsRecords = new DnsRecordCollection();

        $this->resolverFactoryMock->expects($this->once())
            ->method('createDnsResolver')
            ->with($this->isInstanceOf(DnsRecordCollectionOutputFormatter::class))
            ->willReturn($this->dnsResolverMock);

        $this->dnsResolverMock->expects($this->once())
            ->method('resolve')
            ->with($this->equalTo($domain))
            ->willReturn($dnsRecords);

        $result = $this->lookup->getDnsRecords($domain, $format);

        $this->assertSame($dnsRecords, $result);
    }
}
