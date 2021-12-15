# instagram-php-scraper
Simple solution to scrape Instagram.
Allows to access public Instagram data. Uses retries and high quality proxy rotation so you don't have to worry about it.

This solution uses cloud proxy service to access proxies.
Get your API key on https://rapidapi.com/neotank/api/instagram130

# Examples of usage

See full examples in /examples folder.

## Get user profile data
```php
<?php

require __DIR__ . '/../vendor/autoload.php';

use InstagramScraper\Client;

$client = new Client([
        // get your key on https://rapidapi.com/neotank/api/instagram130
        'rapidapi_key' => 'YOUR-RAPIDAPI-KEY' 
    ]
);

$response = $client->getAccountInfo([
    'username' => 'adele'
]);

echo '<h2>Account info for adele:</h2><pre>';
print_r($response);
echo '</pre>';

?>
```


## Get all user media posts (paginated):

```php
<?php
/**
 * get user posts (without reels)
 */
$response = $client->getAccountMedias([
    'userid' => '13460080',
    // 'first' => 80,
    // 'after' =>  
    // get 'after' cursor from page_info.end_cursor if page_info.has_next_page == 1
]);

```


# Media Proxy (solving CORS issue net::ERR_BLOCKED_BY_RESPONSE)
If you want to display Instagram images on your website, you need to proxy images through your server to avoid cors error and broken images.

## Example of media proxy:
put this in separate php file in web server accessible folder and call it from your other html files as mediaproxy.php?url={{INSTAGRAM_IMAGE_URL}}

```php
require __DIR__ . '/../vendor/autoload.php';


use InstagramScraper\MediaProxy;

// use allowedReferersRegex to restrict other websites hotlinking images from your website
$proxy = new MediaProxy(['allowedReferersRegex' => "/(yourwebsite\.com|anotherallowedwebsite\.com)$/"]);

$proxy->handle($_GET, $_SERVER);
```

