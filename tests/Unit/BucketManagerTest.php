<?php

namespace PaulhenriL\FileArray\Tests\Unit;

use PaulhenriL\FileArray\BucketManager;
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
}
