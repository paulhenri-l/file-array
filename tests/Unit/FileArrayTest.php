<?php

namespace PaulhenriL\FileArray\Tests\Unit;

use PaulhenriL\FileArray\BucketManager;
use PaulhenriL\FileArray\Tests\TestCase;
use PaulhenriL\FileArray\FileArray;

class FileArrayTest extends TestCase
{
    public function test_construction()
    {
        $this->assertInstanceOf(
            FileArray::class, new FileArray()
        );
    }

    public function test_with_custom_bucket_manager()
    {
        $bm = new BucketManager();

        $fileArray = new FileArray($bm);
        $fileArray['hello'] = 'world';

        $this->assertEquals('world', $bm->get('hello'));
    }

    public function test_set_get()
    {
        $array = new FileArray();

        $array['hello'] = 'world';

        $this->assertEquals('world', $array['hello']);
    }

    public function test_unset()
    {
        $array = new FileArray();

        $array['hello'] = 'world';
        unset($array['hello']);

        $this->assertNull($array['hello']);
    }

    public function test_has_key()
    {
        $array1 = new FileArray();
        $array2 = new FileArray();

        $array1['hello'] = 'world';

        $this->assertTrue(isset($array1['hello']));
        $this->assertFalse(isset($array2['hello']));
    }

    public function test_empty()
    {
        $array1 = new FileArray();
        $array2 = new FileArray();

        $array1['hello'] = null;

        $this->assertTrue(empty($array1['hello']));
        $this->assertTrue(empty($array2['hello']));
    }
}
