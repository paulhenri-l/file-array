<?php

namespace PaulhenriL\FileArray\Tests\Unit;

use PaulhenriL\FileArray\InMemoryBucket;
use PaulhenriL\FileArray\InMemoryBucketFactory;
use PaulhenriL\FileArray\Tests\TestCase;

class BucketFactoryTest extends TestCase
{
    public function test_a_bucket_can_be_created()
    {
        $factory = new InMemoryBucketFactory();

        $this->assertInstanceOf(InMemoryBucket::class, $factory->newBucket());
    }
}
