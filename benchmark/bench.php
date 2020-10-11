<?php

use PaulhenriL\FileArray\FileArray;
use PaulhenriL\FileArray\File\FileBucketFactory;

require_once __DIR__ . '/../vendor/autoload.php';

echo "Benchmark" . PHP_EOL;

$data = fopen($testDataPath = __DIR__ . '/test_data.csv', 'w+');
$hmDir = __DIR__ . '/h_map';
mkdir($hmDir);

echo " - Generating test data (1 million lines)" . PHP_EOL;

for ($i = 0; $i < 1000000; $i++) {
    fputcsv($data, [md5($i)]);
}

$tests = [
    [
        'buckets' => 1,
        'pointers' => 100,
    ],
    [
        'buckets' => 10,
        'pointers' => 100,
    ],
    [
        'buckets' => 50,
        'pointers' => 100,
    ],
    [
        'buckets' => 100,
        'pointers' => 100,
    ],
    [
        'buckets' => 200,
        'pointers' => 100,
    ],
    [
        'buckets' => 1000,
        'pointers' => 100,
    ],
    [
        'buckets' => 10000,
        'pointers' => 100,
    ],
    [
        'buckets' => 100000,
        'pointers' => 100,
    ],
];

echo PHP_EOL . "Running tests" . PHP_EOL;

foreach ($tests as $test) {
    echo "- test with {$test['buckets']} buckets and {$test['pointers']} pointers:" . PHP_EOL;
    rewind($data);

    $hm = new FileArray(
        $test['buckets'],
        $test['pointers'],
        new FileBucketFactory($hmDir)
    );

    // Load
    $start = microtime(true);

    while ($line = fgetcsv($data)) {
        $hm[$line[0]] = true;
    }

    $loadDuration = microtime(true) - $start;
    echo "  load duration: " . round($loadDuration, 2) . 's' . PHP_EOL;

    // Lookup
    rewind($data);
    $durations = 0;
    $count = 0;
    for ($i = 0; $i < 10; $i++) {
        $hm['lookup' . $i] = true;
    }

    for ($i = 0; $i < 10; $i++) {
        $start = microtime(true);
        $lookup = $hm['lookup' . $i] === true;
        $lookupDuration = microtime(true) - $start;

        $count++;
        $durations = $lookupDuration;
    }

    echo "  lookup duration: " . number_format((($durations*1000) / $count), 4) . 'ms' . PHP_EOL . PHP_EOL;

    unset($hm);
}

unlink($testDataPath);
rmdir($hmDir);
