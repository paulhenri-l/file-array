<?php

namespace PaulhenriL\FileArray\Tests\Unit;

use PaulhenriL\FileArray\File\FileBucket;
use PaulhenriL\FileArray\Tests\TestCase;

class FileBucketTest extends TestCase
{
    public function test_bucket_creation()
    {
        $bucket = new FileBucket('bucket_hash', $this->tmpDir);

        $this->assertInstanceOf(FileBucket::class, $bucket);
    }

    public function test_on_creation_a_file_is_created_with_the_bucket()
    {
        $bucket = $this->newBucket();

        $file = $bucket->getUnderlyingFilePath();

        $this->assertContains('tmp/bucket_hash', $file);
    }

    public function test_on_set_the_value_is_added_to_the_file()
    {
        $bucket = $this->newBucket();

        $bucket->set('hello', 'world');

        $this->assertContains('hello,"s:5:""world"";"', file_get_contents($bucket->getUnderlyingFilePath()));
    }

    public function test_get_value()
    {
        $bucket = $this->newBucket();
        $bucket->set('hello', 'world');
        $bucket->set('some_key', 'some_value');
        $bucket->set('some_int', 1);
        $bucket->set('some_bool', true);
        $bucket->set('some_array', []);

        $this->assertEquals('world', $bucket->get('hello'));
        $this->assertEquals('some_value', $bucket->get('some_key'));
        $this->assertEquals(1, $bucket->get('some_int'));
        $this->assertEquals(true, $bucket->get('some_bool'));
        $this->assertEquals([], $bucket->get('some_array'));
    }

    public function test_has_key()
    {
        $bucket = $this->newBucket();

        $this->assertFalse($bucket->hasKey('hello'));
        $bucket->set('hello', 1);
        $this->assertTrue($bucket->hasKey('hello'));
    }

    public function test_unset()
    {
        $bucket = $this->newBucket();

        $bucket->set('hello', 1);
        $bucket->set('some_key', 'some_value');
        $bucket->unset('hello');

        $this->assertNull($bucket->get('hello'));
        $this->assertEquals('some_value', $bucket->get('some_key'));
    }

    public function test_set_can_override()
    {
        $bucket = $this->newBucket();
        $bucket->set('hello', 'world');
        $bucket->set('hello', 'ph');

        $this->assertEquals('ph', $bucket->get('hello'));
    }

    protected function newBucket(): FileBucket
    {
        return new FileBucket('bucket_hash', $this->tmpDir);
    }
}
