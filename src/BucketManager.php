<?php

namespace PaulhenriL\FileArray;

use PaulhenriL\FileArray\InMemory\InMemoryBucketFactory;

class BucketManager implements BucketManagerInterface
{
    protected $buckets = [];

    /** @var int */
    protected $numberOfBuckets;

    /** @var BucketFactoryInterface */
    protected $bucketFactory;

    public function __construct(
        int $numberOfBuckets = 100,
        ?BucketFactoryInterface $bucketFactory = null
    ) {
        $this->numberOfBuckets = $numberOfBuckets;
        $this->bucketFactory = $bucketFactory ?? new InMemoryBucketFactory();
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

    protected function getBucketFor(string $key): BucketInterface
    {
        $hash = $this->getBucketHashForKey($key);

        return $this->buckets[$hash] ?? $this->bucketFactory->newBucket($hash);
    }

    protected function setBucketFor(string $key, BucketInterface $bucket): void
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
