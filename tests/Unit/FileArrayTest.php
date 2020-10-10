<?php

namespace PaulhenriL\FileArray\Tests\Unit;

use PaulhenriL\FileArray\FileArray;
use PaulhenriL\FileArray\Tests\Fakes\FakeBucket;
use PaulhenriL\FileArray\Tests\Fakes\FakeBucketFactory;
use PaulhenriL\FileArray\Tests\TestCase;

class FileArrayTest extends TestCase
{
    public function test_set_get_array_access()
    {
        $array = new FileArray();

        $array['hello'] = 'world';

        $this->assertEquals('world', $array['hello']);
    }

    public function test_unset_array_access()
    {
        $array = new FileArray();

        $array['hello'] = 'world';
        unset($array['hello']);

        $this->assertNull($array['hello']);
    }

    public function test_has_key_array_access()
    {
        $array1 = new FileArray();
        $array2 = new FileArray();

        $array1['hello'] = 'world';

        $this->assertTrue(isset($array1['hello']));
        $this->assertFalse(isset($array2['hello']));
    }

    public function test_empty_array_access()
    {
        $array1 = new FileArray();
        $array2 = new FileArray();

        $array1['hello'] = null;

        $this->assertTrue(empty($array1['hello']));
        $this->assertTrue(empty($array2['hello']));
    }

    public function test_get_defaults_to_false()
    {
        $bm = new FileArray();

        $this->assertNull($bm->get('some_key'));
    }

    public function test_a_key_can_be_set()
    {
        $bm = new FileArray();

        $bm->set('some_key', 'some_value');

        $this->assertEquals('some_value', $bm->get('some_key'));
    }

    public function test_has_key_when_no_key()
    {
        $bm = new FileArray();

        $this->assertFalse($bm->hasKey('some_key'));
    }

    public function test_has_key_when_has_key()
    {
        $bm = new FileArray();

        $bm->set('some_key', []);

        $this->assertTrue($bm->hasKey('some_key'));
    }

    public function test_unset()
    {
        $bm = new FileArray();
        $bm->set('some_key', ['some' => 'value']);

        $bm->unset('some_key');

        $this->assertNull($bm->get('some_key'));
    }

    public function test_get_underlying_buckets()
    {
        $bm = new FileArray();
        $bm->set('hello', 'world');

        $this->assertCount(1, $bm->getBuckets());
    }

    public function test_bucket_factory_can_be_passed()
    {
        $bm = new FileArray(100, new FakeBucketFactory());

        $bm->set('hello', 'world');

        foreach ($bm->getBuckets() as $bucket) {
            $this->assertInstanceOf(FakeBucket::class, $bucket);
        }
    }

    public function test_different_arrays_do_not_use_same_files()
    {
        $array1 = new FileArray();
        $array2 = new FileArray();

        $array1['hello'] = 'world';

        $this->assertNotEquals($array1['hello'], $array2['hello']);
    }
}

