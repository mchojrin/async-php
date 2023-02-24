<?php

declare(strict_types=1);
require 'vendor/autoload.php';

$before = microtime(true);

$browser = new React\Http\Browser();
$urls = [
    "Cats" => "https://meowfacts.herokuapp.com/",
    "Dogs" => "https://dogapi.dog/api/v2/breeds/68f47c5a-5115-47cd-9849-e45d3c378f12",
    "Calendar" => "http://calapi.inadiutorium.cz/api/v0/en/calendars/default/today",
];

$promises = [];
foreach ($urls as $name => $url) {
    $promises[$name] = $browser
        ->get($url)
        ->then(
            function (Psr\Http\Message\ResponseInterface $response) use ($name) {
                echo "$name API response:" . PHP_EOL;
                echo $response->getBody() . PHP_EOL;
            },
            function (Exception $e) {
                echo 'Error: ' . $e->getMessage() . PHP_EOL;
            });
}

try {
    React\Async\await(React\Promise\all($promises));
    echo "Time elapsed: ".(microtime(true) - $before).PHP_EOL;
} catch (Throwable $e) {
    foreach ($promises as $promise) {
        $promise->cancel();
    }
}