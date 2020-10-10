<?php

namespace PaulhenriL\FileArray\Tests\Fakes;

use PaulhenriL\FileArray\BucketFactoryInterface;
use PaulhenriL\FileArray\BucketInterface;

class FakeBucketFactory implements BucketFactoryInterface
{
    public function newBucket(string $bucketHash): BucketInterface
    {
        return new FakeBucket();
    }
}
