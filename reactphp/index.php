<?php

declare(strict_types=1);

use React\Filesystem\Factory;
use React\Filesystem\Node\FileInterface;

require 'vendor/autoload.php';

$before = microtime(true);

//Factory::create()->detect(__FILE__)->then(function (FileInterface $file) {
//    return $file->getContents();
//})->then(static function (string $contents): void {
//    echo $contents;
//})->done();

$factory = new React\MySQL\Factory();
$connection = $factory->createLazyConnection("homestead:secret@database/books");

$connection->query("SELECT * FROM book")->then(function (QueryResult $command) {
    if (isset($command->resultRows)) {
        // this is a response to a SELECT etc. with some rows (0+)
        print_r($command->resultFields);
        print_r($command->resultRows);
        echo count($command->resultRows) . ' row(s) in set' . PHP_EOL;
    } else {
        // this is an OK message in response to an UPDATE etc.
        if ($command->insertId !== 0) {
            var_dump('last insert ID', $command->insertId);
        }
        echo 'Query OK, ' . $command->affectedRows . ' row(s) affected' . PHP_EOL;
    }
}, function (Exception $error) {
    // the query was not executed successfully
    echo 'Error: ' . $error->getMessage() . PHP_EOL;
});

echo "Time elapsed: ".(microtime(true) - $before).PHP_EOL;
