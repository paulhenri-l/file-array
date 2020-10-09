<?php

namespace PaulhenriL\FileArray\Tests\Unit;

use PaulhenriL\FileArray\Bucket;
use PaulhenriL\FileArray\BucketManager;
use PaulhenriL\FileArray\Tests\TestCase;

class BucketManagerTest extends TestCase
{
    public function test_get_on_non_existing_bucket()
    {
        $bm = new BucketManager();

        $this->assertInstanceOf(Bucket::class, $bm->getBucket('some_key'));
    }

    public function test_a_bucket_can_be_saved()
    {
        $bm = new BucketManager();
        $bucket = new Bucket();
        $bucket['hello'] = 'world';

        $bm->saveBucket('hello', $bucket);

        $this->assertEquals('world', $bm->getBucket('hello')['hello']);
    }
}
