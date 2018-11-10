<?php

namespace App\Services\LastFm\Http;

use Exception;
use RuntimeException;

class ScrobbleClient
{
    const VAR_GET_RECENT_TRACKS_METHOD = 'user.getrecenttracks';
    const VAR_LAST_FM_USER = 'rumplesnelson';

    /** @var ApiClient */
    private $client;

    /**
     * ScrobbleClient constructor.
     * @param ApiClient $client
     */
    public function __construct(ApiClient $client) {
        $this->client = $client;
    }


    /**
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getRecentTracks()
    {
        $params = [
            'method' => self::VAR_GET_RECENT_TRACKS_METHOD,
            'user' => self::VAR_LAST_FM_USER
        ];

        try {
            $response = $this->client->post('', $params);
        } catch (Exception $exception) {
            throw new RuntimeException($exception->getMessage());
        }

        dd(json_decode($response->getBody()->getContents(), true));

        return $response;
    }
}