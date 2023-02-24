<?php

require_once 'vendor/autoload.php';

use OpenSwoole\Coroutine\HTTP\Client;
$before = microtime(true);

$urls = [
    "Cats" => "https://meowfacts.herokuapp.com/",
    "Dogs" => "https://dogapi.dog/api/v2/breeds/68f47c5a-5115-47cd-9849-e45d3c378f12",
    "Calendar" => "http://calapi.inadiutorium.cz/api/v0/en/calendars/default/today",
];

co::run(function() use ($urls)
{
        foreach ( $urls as $name => $url ) {
                go(function() use ($name, $url) {
                        $urlInfo = parse_url($url);
                        $host = $urlInfo['host'];
                        $path = $urlInfo['path'] ?? '/';
                        $scheme = $urlInfo['scheme'];

                        $client = new Client("$host", "https" === $scheme ? 443 : 80, "https" === $scheme);

                          $client->setHeaders([
                              'Host' => $host,
                              "User-Agent" => 'Chrome/49.0.2587.3',
                              'Accept' => 'text/html,application/xhtml+xml,application/xml',
                              'Accept-Encoding' => 'gzip',
                          ]);

                          $client->set(['timeout' => 10000]);

                          $client->get($path);

                          if ($client->errCode) {
                                  echo "Error: ".$client->errMsg.PHP_EOL;
                           } else {
                                  echo "$name API response:".PHP_EOL.$client->body.PHP_EOL;
                          }
                          $client->close();
                });
        }

});
echo "Time elapsed: ".(microtime(true) - $before).PHP_EOL;
