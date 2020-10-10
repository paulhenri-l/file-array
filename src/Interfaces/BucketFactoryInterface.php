<?php

namespace PaulhenriL\FileArray\Interfaces;

interface BucketFactoryInterface
{
    public function newBucket(string $bucketHash): BucketInterface;
}
