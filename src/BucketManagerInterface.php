<?php

namespace PaulhenriL\FileArray;

interface BucketManagerInterface
{
    /**
     * Find the bucket holding this value and return the value at the given key
     * or null if none can be found.
     */
    public function get(string $key);

    /**
     * Find the bucket responsible for this key and set the value at the given
     * key.
     */
    public function set(string $key, $value): void;

    /**
     * Checks if the underlying bucket as something set at the given key. This
     * should return true even if the value is null.
     */
    public function hasKey(string $key): bool;

    /**
     * Remove the key value pair from the underlying bucket. If the bucket is
     * empty it will be destroyed.
     */
    public function unset(string $key): void;

    /**
     * Return all of the Buckets managed by this manager.
     */
    public function getBuckets(): array;
}
