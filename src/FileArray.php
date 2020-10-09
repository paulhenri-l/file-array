<?php

namespace PaulhenriL\FileArray;

class FileArray implements \ArrayAccess
{
    /** @var string */
    protected $filesDirectory;

    /** @var BucketManager */
    protected $bucketManager;

    public function __construct(string $filesDirectory)
    {
        $this->filesDirectory = $filesDirectory;
        $this->bucketManager = new BucketManager();
    }

    public function offsetExists($key)
    {
        return isset($this->bucketManager->getBucket($key)[$key]);
    }

    public function offsetGet($key)
    {
        return $this->bucketManager->getBucket($key)[$key];
    }

    public function offsetSet($key, $value)
    {
        $bucket = $this->bucketManager->getBucket($key);

        $bucket[$key] = $value;

        $this->bucketManager->saveBucket($key, $bucket);
    }

    public function offsetUnset($key)
    {
        $bucket = $this->bucketManager->getBucket($key);

        unset($bucket[$key]);

        // Should remove it if empty
        $this->bucketManager->saveBucket($key, $bucket);
    }
}
