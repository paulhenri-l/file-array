<?php

namespace PaulhenriL\FileArray\File;

use PaulhenriL\FileArray\Interfaces\BucketInterface;

class FileBucket implements BucketInterface
{
    /** @var string */
    protected $bucketFilePath;

    /** @var resource */
    protected $file;

    public function __construct(string $bucketHash, string $tmpDir)
    {
        $this->bucketFilePath = $tmpDir . '/' . $bucketHash . '.bucket';

        $this->file = fopen($this->bucketFilePath, 'c+');
    }

    public function getUnderlyingFilePath()
    {
        return $this->bucketFilePath;
    }

    public function get(string $key)
    {
        $value = null;
        rewind($this->file);

        while ($line = fgetcsv($this->file)) {
            if ($line[0] == $key) {
                $value = unserialize($line[1]);
                break;
            }
        }

        return $value;
    }

    public function set(string $key, $value): void
    {
        if ($this->hasKey($key)) {
            $this->unset($key);
        }

        // Try rewind

        fseek($this->file, 0, SEEK_END);
        fputcsv($this->file, [$key, serialize($value)]);
    }

    public function hasKey(string $key): bool
    {
        rewind($this->file);

        while ($line = fgetcsv($this->file)) {
            if ($line[0] == $key) {
                return true;
            }
        }

        return false;
    }

    public function unset(string $key): void
    {
        rewind($this->file);
        $f = fopen(
            $futureFile = $this->bucketFilePath . '.future', 'c+'
        );

        while ($line = fgetcsv($this->file)) {
            if ($line[0] != $key) {
                fputcsv($f, $line);
            }
        }

        fclose($f);
        fclose($this->file);
        unlink($this->bucketFilePath);
        rename($futureFile, $this->bucketFilePath);
        $this->file = fopen($this->bucketFilePath, 'c+');
    }

    public function length(): int
    {
        $count = 0;
        rewind($this->file);

        while ($l = fgets($this->file)) {
            $count++;
        }

        return $count;
    }

    public function __destruct()
    {
        if (is_resource($this->file)) {
            fclose($this->file);
        }
    }
}
