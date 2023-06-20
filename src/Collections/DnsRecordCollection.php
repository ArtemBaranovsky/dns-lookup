<?php

namespace ArtemBaranovskyi\DnsLookup\Collections;

use ArrayIterator;
use ArtemBaranovskyi\DnsLookup\Models\DnsRecord;
use IteratorAggregate;

class DnsRecordCollection implements IteratorAggregate
{
    /**
     * @var array
     */
    private array $records = [];

    /**
     * @param DnsRecord $record
     * @return void
     */
    public function add(DnsRecord $record): void
    {
        $this->records[] = $record;
    }

    /**
     * @param DnsRecord $record
     * @return void
     */
    public function remove(DnsRecord $record): void
    {
        $index = array_search($record, $this->records, true);
        if ($index !== false) {
            unset($this->records[$index]);
        }
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        return $this->records;
    }

    /**
     * @return ArrayIterator
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->records);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $result = [];

        foreach ($this->records as $record) {
            $result[] = $record->toArray();
        }

        return $result;
    }
}

