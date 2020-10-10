<?php

namespace PaulhenriL\FileArray\InMemory;

use PaulhenriL\FileArray\Interfaces\BucketInterface;

class InMemoryBucket implements BucketInterface
{
    /** @var array */
    protected $data = [];

    public function get(string $key)
    {
        return $this->data[$key] ?? null;
    }

    public function set(string $key, $value): void
    {
        $this->data[$key] = $value;
    }

    public function hasKey(string $key): bool
    {
        return array_key_exists($key, $this->data);
    }

    public function unset(string $key): void
    {
        unset($this->data[$key]);
    }
}
