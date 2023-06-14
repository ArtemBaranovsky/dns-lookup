<?php

namespace ArtemBaranovskyi\DnsLookup;

use ArtemBaranovskyi\DnsLookup\Collections\DnsRecordCollection;
use ArtemBaranovskyi\DnsLookup\Exceptions\DnsQueryException;
use ArtemBaranovskyi\DnsLookup\Exceptions\InvalidDomainException;
use ArtemBaranovskyi\DnsLookup\Exceptions\InvalidOutputFormatException;
use ArtemBaranovskyi\DnsLookup\Formatters\OutputFormatterInterface;
use ArtemBaranovskyi\DnsLookup\Models\DnsRecord;
use Exception;
use Psr\Log\LoggerInterface;

class DnsResolver implements DnsResolverInterface
{
    /**
     * @param LoggerInterface $logger
     */
    public function __construct(private LoggerInterface $logger)
    {
    }

    /**
     * @throws InvalidDomainException
     * @throws DnsQueryException
     * @throws InvalidOutputFormatException
     */
    public function resolve(string $domain, string $format = 'array'): DnsRecordCollection
    {
        try {
            if (!in_array($format, ['array', 'collection'])) {
                throw new InvalidOutputFormatException("Wrong output format provided");
            }

            if (empty($domain)) {
                throw new InvalidDomainException("Domain name is required");
            }

            if (!filter_var($domain, FILTER_VALIDATE_DOMAIN)) {
                throw new InvalidDomainException("Provided domain name is incorrect");
            }

            $dnsRecords = dns_get_record($domain, DNS_ANY);
            if ($dnsRecords === false) {
                throw new DnsQueryException("DNS query failed");
            }

            $collection = new DnsRecordCollection();
            foreach ($dnsRecords as $record) {
                $collection->add(new DnsRecord(
                    $record["type"],
                    $record["host"],
                    $record["ttl"],
                    $record["txt"] ?? $record["ip"] ?? null
                ));
            }

            return $collection;
        } catch (InvalidOutputFormatException|InvalidDomainException|DnsQueryException $e) {
            $this->logger->error($e->getMessage());
            throw $e;
        } catch (Exception $e) {
            $this->logger->error('An error occurred: ' . $e->getMessage());
            throw $e;
        }
    }
}
