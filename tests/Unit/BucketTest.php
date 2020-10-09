<?php

namespace PaulhenriL\FileArray\Tests\Unit;

use PaulhenriL\FileArray\Bucket;
use PaulhenriL\FileArray\Tests\TestCase;

class BucketTest extends TestCase
{
    public function test_get_missing_key_on_bucket()
    {
        $bucket = new Bucket();

        $this->assertNull($bucket->get('some_key'));
    }

    public function test_set_on_bucket()
    {
        $bucket = new Bucket();

        $bucket->set('hello', 'world');

        $this->assertEquals('world', $bucket->get('hello'));
    }

    public function test_construction()
    {
        $this->assertInstanceOf(Bucket::class, new Bucket());
    }

    public function test_set_get()
    {
        $bucket = new Bucket();

        $bucket['hello'] = 'world';

        $this->assertEquals('world', $bucket['hello']);
    }

    public function test_unset()
    {
        $bucket = new Bucket();

        $bucket['hello'] = 'world';
        unset($bucket['hello']);

        $this->assertNull($bucket['hello']);
    }

    public function test_has_key()
    {
        $bucket1 = new Bucket();
        $bucket2 = new Bucket();

        $bucket1['hello'] = 'world';

        $this->assertTrue(isset($bucket1['hello']));
        $this->assertFalse(isset($bucket2['hello']));
    }

    public function test_empty()
    {
        $bucket1 = new Bucket();
        $bucket2 = new Bucket();

        $bucket1['hello'] = null;

        $this->assertTrue(empty($bucket1['hello']));
        $this->assertTrue(empty($bucket2['hello']));
    }
}
