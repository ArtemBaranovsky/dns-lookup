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
        $outputFormatter = $this->createOutputFormatter($format);

        try {
            $dnsResolver = $this->dnsResolverFactory->createDnsResolver($outputFormatter);
            $dnsRecords = $dnsResolver->resolve($domain);

        } catch (Exception | InvalidArgumentException $e) {
            $this->logger->error($e->getMessage());
        }
        return $dnsRecords;
    }

    /**
     * @param string $format
     * @return OutputFormatterInterface
     */
    private function createOutputFormatter(string $format): OutputFormatterInterface
    {
        if (! in_array($format, ['array', 'collection', 'json'])) {
            throw new InvalidArgumentException('Invalid output format specified');
        }

        return match ($format) {
            'array' => new ArrayOutputFormatter(),
            'collection' => new DnsRecordCollectionOutputFormatter(),
            'json' => new JsonOutputFormatter(),
        };
    }
}