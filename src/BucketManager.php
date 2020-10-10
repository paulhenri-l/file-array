<?php

namespace PaulhenriL\FileArray;

class BucketManager
{
    protected $buckets = [];

    public function get(string $key)
    {
        $bucket = $this->getBucketFor($key);

        return $bucket->get($key);
    }

    public function set(string $key, $value): void
    {
        $bucket = $this->getBucketFor($key);

        $bucket->set($key, $value);

        $this->setBucketFor($key, $bucket);
    }

    public function hasKey(string $key): bool
    {
        return $this->getBucketFor($key)->hasKey($key);
    }

    public function unset(string $key): void
    {
        // Should drop bucket if it is empty now.
        $this->getBucketFor($key)->unset($key);
    }

    protected function getBucketFor(string $key): Bucket
    {
        $hash = $this->getBucketHashForKey($key);

        return $this->buckets[$hash] ?? new Bucket();
    }

    protected function setBucketFor(string $key, Bucket $bucket): void
    {
        $hash = $this->getBucketHashForKey($key);

        $this->buckets[$hash] = $bucket;
    }

    protected function getBucketHashForKey(string $key): string
    {
        return crc32($key) % 10;
    }
}
