<?php

declare(strict_types=1);

require_once 'vendor/autoload.php';

use Spatie\Async\Pool;

$before = microtime(true);
$urls = [
    "Dogs" => "https://dogapi.dog/api/v2/breeds/68f47c5a-5115-47cd-9849-e45d3c378f12",
    "Cats" => "https://meowfacts.herokuapp.com/",
];
echo "Fetching from remote APIs..." . PHP_EOL;

$pool = Pool::create();

foreach ($urls as $name => $url) {
    $pool
        ->add(function () use ($name, $url) {
            $client = new GuzzleHttp\Client();
            return $client->getAsync($url);
        })->then(function ($promise) use ($name) {
            echo "$name API response:".PHP_EOL;
            echo $promise.PHP_EOL;
        })->catch(function (Throwable $exception) use ($name) {
            echo "Failed to connect to: ".$exception->getMessage();
        });
}

$pool->wait();