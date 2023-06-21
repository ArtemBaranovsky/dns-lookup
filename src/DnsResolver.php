<?php

namespace ArtemBaranovskyi\DnsLookup;

use AllowDynamicProperties;
use ArtemBaranovskyi\DnsLookup\Collections\DnsRecordCollection;
use ArtemBaranovskyi\DnsLookup\Exceptions\DnsQueryException;
use ArtemBaranovskyi\DnsLookup\Exceptions\InvalidDomainException;
use ArtemBaranovskyi\DnsLookup\Exceptions\InvalidOutputFormatException;
use ArtemBaranovskyi\DnsLookup\Formatters\OutputFormatterInterface;
use ArtemBaranovskyi\DnsLookup\Models\DnsRecord;
use Exception;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use RuntimeException;

#[AllowDynamicProperties] class DnsResolver implements DnsResolverInterface
{
    /**
     * @param LoggerInterface $logger
     */
    public function __construct(private OutputFormatterInterface $outputFormatter)
    {
        $logDirectory = __DIR__ . '/logs';

        if (!is_dir($logDirectory)) {
            mkdir($logDirectory, 0777, true);
        }

        if (!is_writable($logDirectory)) {
            throw new RuntimeException('The log directory is not writable.');
        } else {
            $logPath = $logDirectory . '/dns_resolver.log';

            $this->logger = new Logger('dns_resolver');
            $handler = new StreamHandler($logPath, Logger::INFO);
            $this->logger->pushHandler($handler);
        }
    }

    /**
     * @throws InvalidDomainException
     * @throws DnsQueryException
     * @throws InvalidOutputFormatException
     */
    public function resolve(string $domain, string $format = 'array'): bool | DnsRecordCollection | array | string
    {
        try {
            if (!in_array($format, ['array', 'collection', 'json'])) {
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
                /** @var DnsRecordCollection $collection */
                $collection->add(new DnsRecord(
                    $record["type"],
                    $record["host"],
                    $record["ttl"],
                    $record["txt"] ?? $record["ip"] ?? null
                ));
            }

            return $this->outputFormatter->format($collection);
        } catch (InvalidOutputFormatException|InvalidDomainException|DnsQueryException $e) {
            $this->logger->error($e->getMessage());
            throw $e;
        } catch (Exception $e) {
            $this->logger->error('An error occurred: ' . $e->getMessage());
            throw $e;
        }
    }
}
