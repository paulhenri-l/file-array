<?php

namespace PaulhenriL\FileArray\File;

use PaulhenriL\FileArray\BucketFactoryInterface;
use PaulhenriL\FileArray\BucketInterface;

class FileBucketFactory implements BucketFactoryInterface
{
    /** @var string|null */
    protected $tmpDir;

    public function __construct(string $tmpDir = null)
    {
        $this->tmpDir = $tmpDir;
    }

    public function newBucket(string $bucketHash): BucketInterface
    {
        return new FileBucket(
            $bucketHash,
            $this->tmpDir ?? sys_get_temp_dir()
        );
    }
}
