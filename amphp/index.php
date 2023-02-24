<?php

require __DIR__ . '/vendor/autoload.php';

$client = new Amp\Artax\DefaultClient;
$before = microtime(true);
$promises = [];

$urls = [
    "Cats" => "https://meowfacts.herokuapp.com/",
    "Dogs" => "https://dogapi.dog/api/v2/breeds/68f47c5a-5115-47cd-9849-e45d3c378f12",
    "Calendar" => "http://calapi.inadiutorium.cz/api/v0/en/calendars/default/today",
];

foreach ($urls as $name => $url) {
    $promises[$url] = Amp\call(function () use ($client, $url, $name) {
        $response = yield $client->request($url);
        $body = yield $response->getBody();

        echo "$name API response:".PHP_EOL."$body".PHP_EOL;

        return $url;
    });
}

try {
    $responses = Amp\Promise\wait(Amp\Promise\all($promises));

    echo "Time elapsed: " . (microtime(true) - $before) . PHP_EOL;
} catch (Throwable $e) {
    die("Failed waiting for promises: ".$e->getMessage());
}