<?php

namespace ArtemBaranovskyi\DnsLookup;

use ArtemBaranovskyi\DnsLookup\Collections\DnsRecordCollection;
use ArtemBaranovskyi\DnsLookup\Factories\DnsResolverFactoryInterface;
use ArtemBaranovskyi\DnsLookup\Formatters\ArrayOutputFormatter;
use ArtemBaranovskyi\DnsLookup\Formatters\DnsRecordCollectionOutputFormatter;
use ArtemBaranovskyi\DnsLookup\Formatters\JsonOutputFormatter;
use ArtemBaranovskyi\DnsLookup\Formatters\OutputFormatterInterface;
use Exception;
use InvalidArgumentException;
use Psr\Log\LoggerInterface;
class DnsLookup
{    public function __construct(
        private DnsResolverFactoryInterface $dnsResolverFactory,
        private LoggerInterface $logger,
    ) {
    }

    /**
     * @param string $domain
     * @param string $format
     * @return DnsRecordCollection|array|string|bool
     */
    public function getDnsRecords(string $domain, string $format = 'array'): DnsRecordCollection | array | string | bool
    {
        try {
            $outputFormatter = $this->createOutputFormatter($format);
            $dnsResolver = $this->dnsResolverFactory->createDnsResolver($outputFormatter);
            $dnsRecords = $dnsResolver->resolve($domain);

        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
        }

        return $this->formatDnsRecords($dnsRecords, $format);
    }

    /**
     * @param string $format
     * @return OutputFormatterInterface
     */
    private function createOutputFormatter(string $format): OutputFormatterInterface
    {
        return match ($format) {
            'array' => new ArrayOutputFormatter(),
            'collection' => new DnsRecordCollectionOutputFormatter(),
            'json' => new JsonOutputFormatter(),
            default => throw new InvalidArgumentException('Invalid output format specified'),
        };
    }

    /**
     * @param DnsRecordCollection $dnsRecords
     * @param string $format
     * @return DnsRecordCollection|array|string|bool
     */
    private function formatDnsRecords(DnsRecordCollection $dnsRecords, string $format): DnsRecordCollection | array | string | bool
    {
        return match ($format) {
            'array' => $dnsRecords->toArray(),
            'collection' => $dnsRecords,
            'json' => json_encode($dnsRecords->toArray()),
            default => throw new InvalidArgumentException('Invalid output format specified'),
        };
    }
}
