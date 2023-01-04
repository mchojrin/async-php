<?php

declare(strict_types=1);

use React\Filesystem\Factory;
use React\Filesystem\Node\FileInterface;

require 'vendor/autoload.php';

$before = microtime(true);

Factory::create()->detect(__FILE__)->then(function (FileInterface $file) {
    return $file->getContents();
})->then(static function (string $contents): void {
    echo $contents;
})->done();

echo "Time elapsed: ".(microtime(true) - $before).PHP_EOL;
