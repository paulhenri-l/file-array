<?php

namespace PaulhenriL\FileArray;

class BucketManager
{
    protected $buckets = [];

    public function getBucket(string $key): array
    {
        $hash = $this->getBucketHashForKey($key);

        return $this->buckets[$hash] ?? [];
    }

    public function saveBucket(string $key, array $bucket): void
    {
        $hash = $this->getBucketHashForKey($key);

        $this->buckets[$hash] = $bucket;
    }

    protected function getBucketHashForKey(string $key): string
    {
        return crc32($key) % 10;
    }
}
