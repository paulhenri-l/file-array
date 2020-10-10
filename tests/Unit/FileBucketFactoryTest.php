<?php

namespace PaulhenriL\FileArray\Tests\Unit;

use PaulhenriL\FileArray\File\FileBucket;
use PaulhenriL\FileArray\File\FileBucketFactory;
use PaulhenriL\FileArray\Tests\TestCase;

class FileBucketFactoryTest extends TestCase
{
    public function test_a_bucket_can_be_created()
    {
        $factory = new FileBucketFactory();

        $this->assertInstanceOf(
            FileBucket::class,
            $factory->newBucket('bucket_hash')
        );
    }

    public function test_tmp_path_is_default_tmp_path()
    {
        $factory = new FileBucketFactory();

        $bucket = $factory->newBucket('bucket_hash');

        $this->assertContains(sys_get_temp_dir(), $bucket->getUnderlyingFilePath());
    }

    public function test_custom_bucket_tmp_path_can_be_used()
    {
        $factory = new FileBucketFactory($this->tmpDir);

        $bucket = $factory->newBucket('bucket_hash');

        $this->assertContains($this->tmpDir, $bucket->getUnderlyingFilePath());
    }
}
