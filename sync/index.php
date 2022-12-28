<?php

declare(strict_types=1);

$before = microtime(true);
$urls = [
    "Cats" => "https://meowfacts.herokuapp.com/",
    "Dogs" => "https://dogapi.dog/api/v2/breeds/68f47c5a-5115-47cd-9849-e45d3c378f12",
];
echo "Fetching from remote APIs...".PHP_EOL;

foreach ($urls as $name => $url) {
    echo "$name API response:".PHP_EOL;
    $response = file_get_contents($url);
    echo $response.PHP_EOL;
}
echo "Time elapsed: " . (microtime(true) - $before) . PHP_EOL;