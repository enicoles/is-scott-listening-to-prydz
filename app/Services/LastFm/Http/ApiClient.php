<?php

namespace App\Services\LastFm\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use function GuzzleHttp\Psr7\build_query;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;

class ApiClient extends Client
{
    /**
     * @param $method
     * @param string $uri
     * @param array $options
     * @return mixed|ResponseInterface
     * @throws GuzzleException
     */
    function request($method, $uri = '', array $options = []) {
        $apiKey = config('services.last_fm.api_key');
        $baseParams = [
            'api_key' => $apiKey,
            'format' => 'json'
        ];

        if(!$apiKey) {
            throw new InvalidArgumentException('Missing Last.fm API Key.');
        }

        $options = array_merge($options, $baseParams);
        $params = build_query($options);

        return parent::request($method, "?{$params}", $options);
    }
}