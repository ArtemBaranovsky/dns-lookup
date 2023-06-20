<?php

namespace ArtemBaranovskyi\DnsLookup\Models;

use ArtemBaranovskyi\DnsLookup\Models\Contracts\DnsRecordInterface;

class DnsRecord implements DnsRecordInterface
{
    /**
     * @param string $type
     * @param string $name
     * @param int $ttl
     * @param string|array|null $data
     */
    public function __construct(protected string            $type,
                                protected string            $name,
                                protected int               $ttl,
                                protected string|array|null $data)
    {
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getTtl(): int
    {
        return $this->ttl;
    }

    /**
     * @return string|array|null
     */
    public function getData(): string|array|null
    {
        return $this->data;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'name' => $this->name,
            'ttl' => $this->ttl,
            'data' => $this->data,
        ];
    }
}

