<?php

namespace PaulhenriL\FileArray\File;

use PaulhenriL\FileArray\Interfaces\BucketFactoryInterface;
use PaulhenriL\FileArray\Interfaces\BucketInterface;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class FileBucketFactory implements BucketFactoryInterface
{
    /** @var string|null */
    protected $tmpDir;

    public function __construct(string $tmpDir = null)
    {
        $this->tmpDir = $tmpDir ?? $this->createTempDirectory();
    }

    public function newBucket(string $bucketHash): BucketInterface
    {
        return new FileBucket(
            $bucketHash, $this->tmpDir
        );
    }

    public function cleanUpCreatedBuckets(): void
    {
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(
                $this->tmpDir, RecursiveDirectoryIterator::SKIP_DOTS
            ),
            RecursiveIteratorIterator::CHILD_FIRST
        );

        foreach ($files as $fileinfo) {
            unlink($fileinfo->getRealPath());
        }
    }

    protected function createTempDirectory(): string
    {
        $tmpDir = sys_get_temp_dir() . '/' . md5(uniqid(true) . spl_object_hash($this));

        if (!is_dir($tmpDir)) {
            mkdir($tmpDir);
        }

        return $tmpDir;
    }
}
