<?php

namespace PaulhenriL\FileArray\File;

use PaulhenriL\FileArray\Interfaces\BucketFactoryInterface;
use PaulhenriL\FileArray\Interfaces\BucketInterface;

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
            $this->tmpDir ?? $this->createTempDirectory()
        );
    }

    protected function createTempDirectory(): string
    {
        $tmpDir = sys_get_temp_dir() . '/' . md5(uniqid() . spl_object_hash($this));

        if (!is_dir($tmpDir)) {
            mkdir($tmpDir);
        }

        return $this->tmpDir = $tmpDir;
    }
}
