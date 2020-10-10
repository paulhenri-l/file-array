<?php

namespace PaulhenriL\FileArray\Tests\Fakes;

use PaulhenriL\FileArray\Interfaces\BucketFactoryInterface;
use PaulhenriL\FileArray\Interfaces\BucketInterface;

class FakeBucketFactory implements BucketFactoryInterface
{
    public function newBucket(string $bucketHash): BucketInterface
    {
        return new FakeBucket();
    }
}
