<?php

namespace PaulhenriL\FileArray;

class BucketManager
{
    protected $buckets = [];

    public function getBucket(string $key): Bucket
    {
        $hash = $this->getBucketHashForKey($key);

        return $this->buckets[$hash] ?? new Bucket();
    }

    public function saveBucket(string $key, Bucket $bucket): void
    {
        $hash = $this->getBucketHashForKey($key);

        $this->buckets[$hash] = $bucket;
    }

    protected function getBucketHashForKey(string $key): string
    {
        return crc32($key) % 10;
    }
}
