<?php
ini_set('display_errors', '1');
require __DIR__ . '/../vendor/autoload.php';

use InstagramScraper\Client;

$client = new Client([
        'rapidapi_key' => '01739a12edmsh958f4d2c881dd09p141969jsna12b0c7bbddf' // get your key on https://rapidapi.com/neotank/api/instagram130
    ]
);


try {
    $response = $client->getAccountInfo([
        'username' => 'adele'
    ]);
    
    echo '<h2>Account info for adele:</h2><pre>';
    print_r($response);
    echo '</pre>';
} catch (GuzzleHttp\Exception\ClientException $e) {
    $response = $e->getResponse();
    
    echo 'Status code: ' . $response->getStatusCode() . "\n";
    echo 'Err message: ' . $e->getMessage() . "\n";
    

}