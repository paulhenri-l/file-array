<?php

namespace PaulhenriL\FileArray;

use PaulhenriL\FileArray\File\FileBucketFactory;
use PaulhenriL\FileArray\Interfaces\BucketFactoryInterface;
use PaulhenriL\FileArray\Interfaces\BucketInterface;

class FileArray implements \ArrayAccess
{
    /** @var array */
    protected $buckets = [];

    /** @var bool */
    protected $persistent = false;

    /** @var int */
    protected $numberOfBuckets;

    /** @var int */
    protected $numberOfBucketsOpen;

    /** @var BucketFactoryInterface */
    protected $bucketFactory;

    public function __construct(
        int $numberOfBuckets = 100,
        int $numberOfBucketsOpen = 100,
        ?BucketFactoryInterface $bucketFactory = null
    ) {
        $this->numberOfBuckets = $numberOfBuckets;
        $this->bucketFactory = $bucketFactory ?? new FileBucketFactory();
        $this->numberOfBucketsOpen = $numberOfBucketsOpen;
    }

    public function offsetExists($offset)
    {
        return $this->hasKey($offset);
    }

    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }

    public function offsetUnset($offset)
    {
        $this->unset($offset);
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
    }

    public function getBuckets(): array
    {
        return $this->buckets;
    }

    public function persistent(bool $true)
    {
        $this->persistent = $true;
    }

    protected function getBucketFor(string $key): BucketInterface
    {
        $hash = $this->getBucketHashForKey($key);

        return $this->buckets[$hash] ?? $this->bucketFactory->newBucket($hash);
    }

    protected function setBucketFor(string $key, BucketInterface $bucket): void
    {
        $hash = $this->getBucketHashForKey($key);

        // Do not keep too much file pointers open
        if (count($this->buckets) > $this->numberOfBucketsOpen) {
            $this->buckets = [];
        }

        $this->buckets[$hash] = $bucket;
    }

    protected function getBucketHashForKey(string $key): string
    {
        return crc32($key) % $this->numberOfBuckets;
    }

    public function __destruct()
    {
        if (!$this->persistent) {
            $this->bucketFactory->cleanUpCreatedBuckets();
        }
    }
}
