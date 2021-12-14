<?php

namespace InstagramScraper;

use GuzzleHttp\Client as GuzzleClient;

class Client {
    private $guzzleClient;
    public function __construct(array $config = [])
    {
        if (!isset($config['rapidapi_key'])) {
            throw new \Exception('rapidapi_key must be set');
        }
        
        $this->guzzleClient = new GuzzleClient([
            // Base URI is used with relative requests
            'base_uri' => 'https://instagram130.p.rapidapi.com',
            // You can set any number of default request options.
            'timeout'  => 30,
            'headers' => [
                'x-rapidapi-host' => 'instagram130.p.rapidapi.com',
                'x-rapidapi-key' => $config['rapidapi_key'] // get your key on https://rapidapi.com/neotank/api/instagram130
            ]
        ]);

    }

    public function getViaProxy(array $params = []) {
        if (!isset($params['url'])) {
            throw new \Exception('params[url] is required!');
        }
        
        $response = $this->guzzleClient->get('proxy', ['query' => $params]);

        return json_decode($response->getBody(), true);
    }

    public function getAccountInfo(array $params = []) {
        if (!isset($params['username'])) {
            throw new \Exception('params[username] is required!');
        }

        $response = $this->guzzleClient->get('account-info', ['query' => $params]);

        return json_decode($response->getBody(), true);
    }


}