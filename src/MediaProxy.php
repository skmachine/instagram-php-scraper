<?php

namespace InstagramScraper;

use GuzzleHttp\Client as GuzzleClient;

class MediaProxy {
    private $allowedReferersRegex;
    /**
     * Class constructor
     * 
     * @param array $config Array containing the neccessary params
     * $config = [
     *  'referer_regex' => (regex) Your website hostname (to avoid img hotlinking from external websites). Optional. 
     *     Example: "/(yourwebsite\.com|anotherdomain\.com)$/";
     * 
     * ]
     */
    public function __construct(array $config = [])
    {
        if (!isset($config['allowedReferersRegex'])) {
            throw new \Exception('allowedReferersRegex must be set');
        }

        $this->allowedReferersRegex = $config['allowedReferersRegex'];

        $this->guzzleClient = new GuzzleClient([
            'timeout'  => 20
        ]);

    }

    protected function endsWith( $haystack, $needle ) {
        return substr($haystack, -strlen($needle))===$needle;
    }


    public function handle($request, $server) {
        if (!in_array(ini_get('allow_url_fopen'), [1, 'on', 'true'])) {
            throw new \Exception('PHP configuration change is required for image proxy: allow_url_fopen setting must be enabled!');
        } 
        
        $url = isset($request['url']) ? $request['url'] : null;
        
        if (!$url || substr($url, 0, 4) != 'http') {
            http_response_code(422);
            die('Please, provide correct URL');
        }
        
        $parsed = parse_url($url);
        
        if (!empty($this->allowedReferersRegex) && !empty($server['HTTP_REFERER'])) {
            if (!preg_match($this->allowedReferersRegex, parse_url($server['HTTP_REFERER'])['host'])) {
                http_response_code(403);
                die('Invalid referer host.' . parse_url($server['HTTP_REFERER'])['host']);
            }
        }
        
        
        
        $ext = pathinfo($parsed['path'], PATHINFO_EXTENSION);
        
        $goodExt = in_array($ext, ['mp4', 'jpg']);
        
        $mimeTypes = [
            'jpg' => 'image/jpeg',
            'mp4' => 'video/mp4'
        ];
        
        if ((!$this->endsWith($parsed['host'], 'cdninstagram.com') && !$this->endsWith($parsed['host'], 'fbcdn.net')) || !$goodExt) {
            http_response_code(422);
            die('Please, provide correct URL to jpg/mp4 file');
        }

        header("Content-Type: " . $mimeTypes[$ext]);

        $headers = [
            'user-agent' => "Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:94.0) Gecko/20100101 Firefox/94.0"
        ];

        //var_dump(getallheaders());
        $response = $this->guzzleClient->get($url, ['headers' => $headers]);

        header("Content-Type: " . $mimeTypes[$ext]);

        // @TODO: rewrite to streaming
        echo $response->getBody() . '';
    }

    
}
