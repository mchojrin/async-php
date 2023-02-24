<?php

declare(strict_types=1);

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Promise;
use Psr\Http\Message\ResponseInterface;

require_once 'vendor/autoload.php';

$before = microtime(true);
$urls = [
    "Cats" => "https://meowfacts.herokuapp.com/",
    "Dogs" => "https://dogapi.dog/api/v2/breeds/68f47c5a-5115-47cd-9849-e45d3c378f12",
    "Calendar" => "http://calapi.inadiutorium.cz/api/v0/en/calendars/default/today",
];
echo "Fetching from remote APIs..." . PHP_EOL;

$client = new GuzzleHttp\Client();

$promises = [];
foreach ($urls as $name => $url) {
    $promises[$name] = $client->getAsync($url)
        ->then(
            function (ResponseInterface $response) use ($name) {
                return $response->getBody();
            },
            function (RequestException $exception) use ($name) {
                echo "Couldn't fetch info about $name: " . $exception->getMessage() . PHP_EOL;
            });
}

try {
    foreach (Promise\Utils::unwrap($promises) as $name => $response) {
        echo "$name API response:".PHP_EOL."$response".PHP_EOL;
    }
} catch (Throwable $e) {
    echo "Something went wrong: " . $e->getMessage();
}
echo "Time elapsed: " . (microtime(true) - $before) . PHP_EOL;