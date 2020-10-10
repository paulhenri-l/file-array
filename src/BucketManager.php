<?php

namespace PaulhenriL\FileArray;

class BucketManager
{
    protected $buckets = [];

    /** @var int */
    protected $numberOfBuckets;

    public function __construct(int $numberOfBuckets = 100)
    {
        $this->numberOfBuckets = $numberOfBuckets;
    }

    public function get(string $key)
    {
        return $this->getBucketFor($key)->get($key);
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
        $bucket = $this->getBucketFor($key);

        $bucket->unset($key);

        if ($bucket->length() === 0) {
            $this->removeBucketFor($key);
        }
    }

    public function getBuckets(): array
    {
        return $this->buckets;
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

    protected function removeBucketFor(string $key)
    {
        $hash = $this->getBucketHashForKey($key);

        unset($this->buckets[$hash]);
    }

    protected function getBucketHashForKey(string $key): string
    {
        return crc32($key) % $this->numberOfBuckets;
    }
}
