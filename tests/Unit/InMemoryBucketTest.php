<?php

namespace PaulhenriL\FileArray\Tests\Unit;

use PaulhenriL\FileArray\InMemory\InMemoryBucket;
use PaulhenriL\FileArray\Tests\TestCase;

class InMemoryBucketTest extends TestCase
{
    public function test_get_missing_key_on_bucket()
    {
        $bucket = new InMemoryBucket();

        $this->assertNull($bucket->get('some_key'));
    }

    public function test_set_on_bucket()
    {
        $bucket = new InMemoryBucket();

        $bucket->set('hello', 'world');

        $this->assertEquals('world', $bucket->get('hello'));
    }

    public function test_has_key_when_no_key()
    {
        $bucket = new InMemoryBucket();

        $this->assertFalse($bucket->hasKey('some_key'));
    }

    public function test_has_key_when_has_key()
    {
        $bucket = new InMemoryBucket();

        $bucket->set('some_key', []);

        $this->assertTrue($bucket->hasKey('some_key'));
    }

    public function test_unset()
    {
        $bucket = new InMemoryBucket();
        $bucket->set('some_key', ['some' => 'value']);

        $bucket->unset('some_key');

        $this->assertNull($bucket->get('some_key'));
    }

    public function test_length()
    {
        $bucket = new InMemoryBucket();

        $this->assertEquals(0, $bucket->length());

        $bucket->set('hello', 'world');

        $this->assertEquals(1, $bucket->length());
    }
}
