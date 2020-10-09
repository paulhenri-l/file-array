<?php

namespace PaulhenriL\FileArray\Tests\Unit;

use PaulhenriL\FileArray\Tests\TestCase;
use PaulhenriL\FileArray\FileArray;

class FileArrayTest extends TestCase
{
    public function test_construction()
    {
        $this->assertInstanceOf(FileArray::class, new FileArray());
    }
}
