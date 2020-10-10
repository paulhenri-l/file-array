<?php

namespace PaulhenriL\FileArray;

class BucketFactory implements BucketFactoryInterface
{
    public function newBucket(): BucketInterface
    {
        return new Bucket();
    }
}
