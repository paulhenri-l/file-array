<?php

namespace PaulhenriL\FileArray;

class InMemoryBucketFactory implements BucketFactoryInterface
{
    public function newBucket(): BucketInterface
    {
        return new InMemoryBucket();
    }
}
