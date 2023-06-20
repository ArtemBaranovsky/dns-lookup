<?php

namespace ArtemBaranovskyi\DnsLookup\Models\Contracts;

interface DnsRecordInterface
{
    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return int
     */
    public function getTtl(): int;

    /**
     * @return string|array|null
     */
    public function getData(): string|array|null;

    /**
     * @return array
     */
    public function toArray(): array;
}
