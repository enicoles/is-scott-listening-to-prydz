<?php

namespace App\Services\LastFm\Http;

use Exception;
use RuntimeException;

class ScrobbleClient
{
    const VAR_GET_RECENT_TRACKS_METHOD = 'user.getrecenttracks';
    const VAR_LAST_FM_USER = 'enicoles';
    const API_KEY_RECENT_TRACKS = 'recenttracks.track';

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
     * @return array
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

        $response = json_decode($response->getBody()->getContents(), true);
        $recentTracks = array_get($response, self::API_KEY_RECENT_TRACKS);

        return $recentTracks;
    }
}