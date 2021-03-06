<?php

namespace PaulhenriL\FileArray\Tests\Fakes;

use PaulhenriL\FileArray\Interfaces\BucketInterface;

class FakeBucket implements BucketInterface
{
    public function get(string $key)
    {
        return null;
    }

    public function set(string $key, $value): void
    {
        //
    }

    public function hasKey(string $key): bool
    {
        return false;
    }

    public function unset(string $key): void
    {
        //
    }
}
