<?php

namespace PaulhenriL\FileArray\Tests\Unit;

use PaulhenriL\FileArray\Tests\TestCase;
use PaulhenriL\FileArray\FileArray;

class FileArrayTest extends TestCase
{
    /** @var string */
    protected $tmpDir;

    protected function setUp()
    {
        parent::setUp();

        $this->tmpDir = __DIR__ . '/../tmp';

        if (!file_exists($this->tmpDir)) {
            mkdir($this->tmpDir);
        }
    }

    public function test_construction()
    {
        $this->assertInstanceOf(
            FileArray::class,
            new FileArray($this->tmpDir)
        );
    }

    public function test_set_get()
    {
        $array = new FileArray($this->tmpDir);

        $array['hello'] = 'world';

        $this->assertEquals('world', $array['hello']);
    }

    public function test_unset()
    {
        $array = new FileArray($this->tmpDir);

        $array['hello'] = 'world';
        unset($array['hello']);

        $this->assertNull($array['hello']);
    }

    public function test_has_key()
    {
        $array1 = new FileArray($this->tmpDir);
        $array2 = new FileArray($this->tmpDir);

        $array1['hello'] = 'world';

        $this->assertTrue(isset($array1['hello']));
        $this->assertFalse(isset($array2['hello']));
    }

    public function test_empty()
    {
        $array1 = new FileArray($this->tmpDir);
        $array2 = new FileArray($this->tmpDir);

        $array1['hello'] = null;

        $this->assertTrue(empty($array1['hello']));
        $this->assertTrue(empty($array2['hello']));
    }
}
