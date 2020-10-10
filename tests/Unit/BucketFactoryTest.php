<?php

namespace PaulhenriL\FileArray\Tests\Unit;

use PaulhenriL\FileArray\Bucket;
use PaulhenriL\FileArray\BucketFactory;
use PaulhenriL\FileArray\Tests\TestCase;

class BucketFactoryTest extends TestCase
{
    public function test_a_bucket_can_be_created()
    {
        $factory = new BucketFactory();

        $this->assertInstanceOf(Bucket::class, $factory->newBucket());
    }
}
