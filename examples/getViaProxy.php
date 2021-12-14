<?php
ini_set('display_errors', '1');
require __DIR__ . '/../vendor/autoload.php';

use InstagramScraper\Client;

$client = new Client([
        'rapidapi_key' => 'YOUR-RAPIDAPI-KEY' // get your key on https://rapidapi.com/neotank/api/instagram130
    ]
);


try {
    // getting user tags
    $response = $client->getViaProxy([
        'url' => 'https://www.instagram.com/graphql/query/?query_hash=31fe64d9463cbbe58319dced405c6206&variables=' . urlencode('{"id":"29883180","first":12}')
    ]);
    
    echo '<h2>User tags:</h2><pre>';
    print_r($response);
    echo '</pre>';
} catch (GuzzleHttp\Exception\ClientException $e) {
    $response = $e->getResponse();
    
    echo 'Status code: ' . $response->getStatusCode() . "\n";
    echo 'Err message: ' . $e->getMessage() . "\n";
    

}
