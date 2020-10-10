<?php

namespace PaulhenriL\FileArray\InMemory;

use PaulhenriL\FileArray\Interfaces\BucketFactoryInterface;
use PaulhenriL\FileArray\Interfaces\BucketInterface;

class InMemoryBucketFactory implements BucketFactoryInterface
{
    public function newBucket(string $bucketHash): BucketInterface
    {
        return new InMemoryBucket();
    }

    public function cleanUpCreatedBuckets(): void
    {
        //
    }
}
