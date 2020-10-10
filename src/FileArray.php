<?php

namespace PaulhenriL\FileArray;

class FileArray implements \ArrayAccess
{
    /** @var BucketManager */
    protected $bucketManager;

    public function __construct(BucketManager $bucketManager = null)
    {
        $this->bucketManager = $bucketManager ?? new BucketManager();
    }

    public function offsetExists($key)
    {
        return $this->bucketManager->hasKey($key);
    }

    public function offsetGet($key)
    {
        return $this->bucketManager->get($key);
    }

    public function offsetSet($key, $value)
    {
        $this->bucketManager->set($key, $value);
    }

    public function offsetUnset($key)
    {
        $this->bucketManager->unset($key);
    }
}
