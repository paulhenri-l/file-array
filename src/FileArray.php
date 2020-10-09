<?php

namespace PaulhenriL\FileArray;

class FileArray implements \ArrayAccess
{
    /** @var string */
    protected $filesDirectory;

    protected $buckets = [];

    public function __construct(string $filesDirectory)
    {
        $this->filesDirectory = $filesDirectory;
    }

    public function offsetExists($offset)
    {
        return array_key_exists(
            $offset, $this->getBucketFor($offset)
        );
    }

    public function offsetGet($offset)
    {
        $bucket = $this->getBucketFor($offset);

        return $bucket[$offset] ?? null;
    }

    public function offsetSet($offset, $value)
    {
        $bucket = $this->getBucketFor($offset);

        $bucket[$offset] = $value;

        $this->saveBucket($offset, $bucket);
    }

    public function offsetUnset($offset)
    {
        $bucket = $this->getBucketFor($offset);

        unset($bucket[$offset]);

        // Should remove it if empty
        $this->saveBucket($offset, $bucket);
    }

    protected function getBucketFor(string $key): array
    {
        $bucketHash = $this->getBucketHashForKey($key);

        return $this->buckets[$bucketHash] ?? [];
    }

    protected function saveBucket(string $key, array $bucket): void
    {
        $bucketHash = $this->getBucketHashForKey($key);

        $this->buckets[$bucketHash] = $bucket;
    }

    protected function getBucketHashForKey(string $key): string
    {
        return crc32($key) % 10;
    }
}
