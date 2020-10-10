<?php

namespace PaulhenriL\FileArray;

class InMemoryBucketFactory implements BucketFactoryInterface
{
    public function newBucket(string $bucketHash): BucketInterface
    {
        return new InMemoryBucket();
    }
}
