<?php

namespace app\models;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ConnectException;

class HttpWebsiteChecker
{
    private $httpClient;
    private $clientOptions;

    public function __construct($client = null, $clientOptions = null)
    {
        $this->clientOptions = [
            'http_errors' => false,
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.121 Safari/537.36'
            ]
        ];
        $this->httpClient = new Client($this->clientOptions);
    }

    public function getStatusResponse($websites)
    {
        $myWebsites = $websites;
        foreach ($myWebsites as &$website) {
            try {
                $response = $this->httpClient->request('HEAD', $website['url']);
            } catch (ConnectException | RequestException $e) {
                $website['status'] = 'We’re having trouble finding that site';
                $website['reasonPhrase'] = "";
                continue;
            }
            $website['status'] = $response->getStatusCode();
            $website['reasonPhrase'] = $response->getReasonPhrase();
        }
        return $myWebsites;
    }
}
