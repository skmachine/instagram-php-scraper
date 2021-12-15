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
     * get user posts (without reels)
     */
    $response = $client->getAccountMedias([
        'userid' => '13460080',
        // 'first' => 80,
        // 'after' => 'QVFDbUJ4NUlHbkFycjZTejlibHZMU2h0czk1RmZQNWZwSFdSbkw4VllfdHZNdENYOU1rX1JMcXV1aVp0dzVpWnpYd0ExU0twTnNFYjBGVmJSbWd0U09Zdg==' 
        // get 'after' from page_info.end_cursor if page_info.has_next_page == 1
    ]);


    echo '<h2>User medias (all, paginated):</h2><pre>';
    print_r($response);
    echo '</pre>';

    /**
     * get latest 12 posts, by username (without reels)
     */
    $response = $client->getAccountFeed([
        'username' => 'adele'
    ]);

    echo '<h2>User medias (latest 12):</h2><pre>';
    print_r($response);
    echo '</pre>';


} catch (GuzzleHttp\Exception\ClientException $e) {
    $response = $e->getResponse();
    
    echo 'Status code: ' . $response->getStatusCode() . "\n";
    echo 'Err message: ' . $e->getMessage() . "\n";
    

}
