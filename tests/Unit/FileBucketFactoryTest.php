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

    public function test_uniq_id_is_added_to_default_tmp_dir()
    {
        $factory = new FileBucketFactory();

        $bucket = $factory->newBucket('bucket_hash');
        $file = $bucket->getUnderlyingFilePath();
        $path = explode('/', $file);
        array_pop($path);
        $path = implode('/', $path);

        $this->assertNotEquals(sys_get_temp_dir(), $path);
        $this->assertTrue(is_dir($path));
    }

    public function test_uniq_id_is_the_same_for_all_buckets()
    {
        $factory = new FileBucketFactory();

        $bucket1 = $factory->newBucket('bucket_hash');
        $bucket2 = $factory->newBucket('bucket_hash');

        $this->assertEquals(
            $bucket1->getUnderlyingFilePath(),
            $bucket2->getUnderlyingFilePath()
        );
    }
}
