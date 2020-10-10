<?php

namespace PaulhenriL\FileArray\InMemory;

use PaulhenriL\FileArray\BucketFactoryInterface;
use PaulhenriL\FileArray\BucketInterface;

class InMemoryBucketFactory implements BucketFactoryInterface
{
    public function newBucket(string $bucketHash): BucketInterface
    {
        return new InMemoryBucket();
    }
}
