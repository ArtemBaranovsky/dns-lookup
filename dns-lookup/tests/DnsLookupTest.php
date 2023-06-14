<?php

namespace ArtemBaranovskyi\DnsLookup\Tests;

use ArtemBaranovskyi\DnsLookup\Collections\DnsRecordCollection;
use ArtemBaranovskyi\DnsLookup\DnsLookup;
use ArtemBaranovskyi\DnsLookup\DnsResolverInterface;
use ArtemBaranovskyi\DnsLookup\Factories\DnsResolverFactoryInterface;
use ArtemBaranovskyi\DnsLookup\Formatters\ArrayOutputFormatter;
use ArtemBaranovskyi\DnsLookup\Formatters\DnsRecordCollectionOutputFormatter;
use ArtemBaranovskyi\DnsLookup\Formatters\JsonOutputFormatter;
use ArtemBaranovskyi\DnsLookup\Formatters\OutputFormatterInterface;
use Exception;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class DnsLookupTest extends TestCase
{
    private DnsLookup $lookup;
    private DnsResolverFactoryInterface $resolverFactoryMock;
    private LoggerInterface $loggerMock;

    protected function setUp(): void
    {
        $this->resolverFactoryMock = $this->createMock(DnsResolverFactoryInterface::class);
        $this->loggerMock = $this->createMock(LoggerInterface::class);

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

        $dnsResolverMock = $this->createMock(DnsResolverInterface::class);
        $dnsResolverMock->expects($this->once())
            ->method('resolve')
            ->with($this->equalTo($domain))
            ->willReturn($dnsRecords);

        $this->resolverFactoryMock->expects($this->once())
            ->method('createDnsResolver')
            ->with($this->isInstanceOf(ArrayOutputFormatter::class))
            ->willReturn($dnsResolverMock);

        $result = $this->lookup->getDnsRecords($domain, $format);

        $this->assertIsArray($result);
    }

    /**
     * @throws Exception
     */
    public function testGetDnsRecordsReturnsCollection()
    {
        $dnsResolverFactory = $this->createMock(DnsResolverFactoryInterface::class);
        $logger = $this->createMock(LoggerInterface::class);

        $dnsLookup = new DnsLookup($dnsResolverFactory, $logger);
        $domain = 'example.com';
        $format = 'collection';

        $dnsResolver = $this->createMock(DnsResolverInterface::class);
        $dnsRecords = new DnsRecordCollection();

        $dnsResolverFactory->expects($this->once())
            ->method('createDnsResolver')
            ->with($this->isInstanceOf(DnsRecordCollectionOutputFormatter::class))
            ->willReturn($dnsResolver);

        $dnsResolver->expects($this->once())
            ->method('resolve')
            ->with($domain)
            ->willReturn($dnsRecords);

        $result = $dnsLookup->getDnsRecords($domain, $format);

        $this->assertSame($dnsRecords, $result);
    }
}
