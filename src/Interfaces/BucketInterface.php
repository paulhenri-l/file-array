<?php

namespace PaulhenriL\FileArray\Interfaces;

interface BucketInterface
{
    /**
     * Return the value at the given key or null if none can be found.
     */
    public function get(string $key);

    /**
     * Set the value at the given key.
     */
    public function set(string $key, $value): void;

    /**
     * Checks if the bucket as something set at the given key. This should
     * return true even if the value is null.
     */
    public function hasKey(string $key): bool;

    /**
     * Remove the key value pair from the bucket.
     */
    public function unset(string $key): void;

    /**
     * Return the number of items present in the bucket.
     */
    public function length(): int;
}
