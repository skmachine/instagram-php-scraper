<?php

ini_set('display_errors', '1');
require __DIR__ . '/../vendor/autoload.php';

use InstagramScraper\Client;

$client = new Client([
        'rapidapi_key' => 'YOUR-RAPIDAPI-KEY' // get your key on https://rapidapi.com/neotank/api/instagram130
    ]
);


try {

    /**
     * get username
     */
    $response = $client->getUsernameByID([
        'userid' => '13460080',
    ]);


    echo '<h2>Username:</h2><pre>';
    print_r($response['data']['username']);
    echo '</pre>';



} catch (GuzzleHttp\Exception\ClientException $e) {
    $response = $e->getResponse();
    
    echo 'Status code: ' . $response->getStatusCode() . "\n";
    echo 'Err message: ' . $e->getMessage() . "\n";
    

}
