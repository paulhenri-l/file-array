<?php

namespace PaulhenriL\FileArray;

class Bucket
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

    public function length(): int
    {
        return count($this->data);
    }
}
