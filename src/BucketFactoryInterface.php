<?php

namespace PaulhenriL\FileArray;

interface BucketFactoryInterface
{
    public function newBucket(string $bucketHash): BucketInterface;
}
