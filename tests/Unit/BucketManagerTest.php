<?php

namespace PaulhenriL\FileArray\Tests\Unit;

use PaulhenriL\FileArray\Interfaces\BucketInterface;
use PaulhenriL\FileArray\BucketManager;
use PaulhenriL\FileArray\Interfaces\BucketManagerInterface;
use PaulhenriL\FileArray\Tests\Fakes\FakeBucket;
use PaulhenriL\FileArray\Tests\Fakes\FakeBucketFactory;
use PaulhenriL\FileArray\Tests\TestCase;

class BucketManagerTest extends TestCase
{
    public function test_get_defaults_to_false()
    {
        $bm = new BucketManager();

        $this->assertNull($bm->get('some_key'));
    }

    public function test_a_key_can_be_set()
    {
        $bm = new BucketManager();

        $bm->set('some_key', 'some_value');

        $this->assertEquals('some_value', $bm->get('some_key'));
    }

    public function test_has_key_when_no_key()
    {
        $bm = new BucketManager();

        $this->assertFalse($bm->hasKey('some_key'));
    }

    public function test_has_key_when_has_key()
    {
        $bm = new BucketManager();

        $bm->set('some_key', []);

        $this->assertTrue($bm->hasKey('some_key'));
    }

    public function test_unset()
    {
        $bm = new BucketManager();
        $bm->set('some_key', ['some' => 'value']);

        $bm->unset('some_key');

        $this->assertNull($bm->get('some_key'));
    }

    public function test_bucket_is_removed_on_unset_if_it_is_empty()
    {
        $bm = new BucketManager();
        $bm->set('some_key', 'some_value');
        $this->assertCount(1, $bm->getBuckets());

        $bm->unset('some_key');

        $this->assertCount(0, $bm->getBuckets());
    }

    public function test_bucket_is_not_removed_on_unset_if_it_is_not_empty()
    {
        $bm = new BucketManager(1);
        $bm->set('some_key1', 'some_value1');
        $bm->set('some_key2', 'some_value2');
        $this->assertCount(1, $bm->getBuckets());

        $bm->unset('some_key1');

        $this->assertCount(1, $bm->getBuckets());
    }

    public function test_get_underlying_buckets()
    {
        $bm = new BucketManager();
        $bm->set('hello', 'world');

        $this->assertCount(1, $bm->getBuckets());
    }

    public function test_bucket_factory_can_be_passed()
    {
        $bm = new BucketManager(100, new FakeBucketFactory());

        $bm->set('hello', 'world');

        foreach ($bm->getBuckets() as $bucket) {
            $this->assertInstanceOf(FakeBucket::class, $bucket);
        }
    }
}

