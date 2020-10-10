<?php

namespace PaulhenriL\FileArray\Tests;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class TestCase extends \PHPUnit\Framework\TestCase
{
    /** @var string */
    protected $tmpDir;

    protected function setUp()
    {
        require_once __DIR__ . '/functions/dd.php';

        $this->tmpDir = __DIR__ . '/tmp';

        if (!is_dir($this->tmpDir)) {
            mkdir($this->tmpDir);
        }
    }

    protected function tearDown()
    {
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(
                $this->tmpDir, RecursiveDirectoryIterator::SKIP_DOTS
            ),
            RecursiveIteratorIterator::CHILD_FIRST
        );

        foreach ($files as $fileinfo) {
            if ($fileinfo->getFilename() === '.gitignore') {
                continue;
            }

            $rmFunction = ($fileinfo->isDir() ? 'rmdir' : 'unlink');
            $rmFunction($fileinfo->getRealPath());
        }
    }
}
