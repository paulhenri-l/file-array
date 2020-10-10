<?php

namespace PaulhenriL\FileArray\Interfaces;

interface BucketFactoryInterface
{
    /**
     * Create a new Bucket instance for the given bucket hash.
     */
    public function newBucket(string $bucketHash): BucketInterface;

    /**
     * Cleanup all the data created by your buckets. This method will be called
     * when the array will be garbage collected/destroyed.
     */
    public function cleanUpCreatedBuckets(): void;
}
