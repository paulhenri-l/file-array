<?php

namespace PaulhenriL\FileArray\Tests\Unit;

use PaulhenriL\FileArray\BucketManager;
use PaulhenriL\FileArray\Tests\TestCase;

class BucketManagerTest extends TestCase
{
    public function test_get_on_non_existing_bucket()
    {
        $bm = new BucketManager();

        $this->assertEquals([], $bm->getBucket('some_key'));
    }

    public function test_a_bucket_can_be_saved()
    {
        $bm = new BucketManager();

        $bm->saveBucket('some_key', $bucket = ['some_key' => 'value']);

        $this->assertEquals($bucket, $bm->getBucket('some_key'));
    }
}
