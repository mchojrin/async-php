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
];
echo "Fetching from remote APIs...".PHP_EOL;

$client = new GuzzleHttp\Client();

$promises = [];
foreach ($urls as $name => $url) {
    $promises[] = $client->getAsync($url)
        ->then(
            function(ResponseInterface $response) use ($name) {
            return "$name API response:".PHP_EOL.$response->getBody().PHP_EOL;
        }, function (RequestException $exception) use ($name) {
                echo "Couldn't fetch info about $name: ".$exception->getMessage().PHP_EOL;
        });
}
try {
    $responses = Promise\Utils::unwrap($promises);
    foreach ($responses as $response) {
        echo $response;
    }
} catch (Throwable $e) {
    echo "Something went wrong: ".$e->getMessage();
}
echo "Time elapsed: " . (microtime(true) - $before) . PHP_EOL;