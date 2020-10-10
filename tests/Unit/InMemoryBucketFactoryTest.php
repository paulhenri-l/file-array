<?php

namespace PaulhenriL\FileArray\Tests\Unit;

use PaulhenriL\FileArray\InMemory\InMemoryBucket;
use PaulhenriL\FileArray\InMemory\InMemoryBucketFactory;
use PaulhenriL\FileArray\Tests\TestCase;

class InMemoryBucketFactoryTest extends TestCase
{
    public function test_a_bucket_can_be_created()
    {
        $factory = new InMemoryBucketFactory();

        $this->assertInstanceOf(
            InMemoryBucket::class,
            $factory->newBucket('bucket_hash')
        );
    }
}
