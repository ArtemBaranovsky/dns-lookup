<?php

namespace ArtemBaranovskyi\DnsLookup;

use ArtemBaranovskyi\DnsLookup\Collections\DnsRecordCollection;
use ArtemBaranovskyi\DnsLookup\Exceptions\DnsQueryException;
use ArtemBaranovskyi\DnsLookup\Exceptions\InvalidDomainException;
use ArtemBaranovskyi\DnsLookup\Models\DnsRecord;
use Exception;
use Monolog\Logger;
use Psr\Log\LogLevel;
use Monolog\Handler\StreamHandler;

class DnsLookup
{
    /**
     * @param string $domain
     * @return DnsRecordCollection | array
     * @throws Exception
     */
    public function getDnsRecords(string $domain, string $type = 'array'): DnsRecordCollection | array
    {
        $logger = new Logger('dns-lookup');
        $logger->pushHandler(new StreamHandler(__DIR__ . '/logs/error.log', LogLevel::ERROR));

        try {
            if (! in_array($type, ['array', 'collection'])) {
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

        } catch (InvalidOutputFormatException $e) {
            $logger->error('Wrong result format provided: ' . $e->getMessage());
        } catch (InvalidDomainException $e) {
            $logger->error('Invalid domain name $domain: ' . $e->getMessage());
        } catch (DnsQueryException $e) {
            $logger->error('DNS query to $domain failed: ' . $e->getMessage());
        } catch (Exception $e) {
            $logger->error('An error occurred: ' . $e->getMessage());
        }

//        print_r($collection->toArray());

        return ($type == 'collection') ? $collection : $collection->toArray();
    }
}
