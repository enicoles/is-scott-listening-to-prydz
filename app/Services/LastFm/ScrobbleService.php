<?php

namespace App\Services\LastFm;

use App\Services\LastFm\Http\ScrobbleClient;

class ScrobbleService
{
    /** @var ScrobbleClient $scrobbleClient */
    private $scrobbleClient;

    /**
     * ScrobbleService constructor.
     * @param ScrobbleClient $scrobbleClient
     */
    public function __construct(ScrobbleClient $scrobbleClient){
        $this->scrobbleClient = $scrobbleClient;
    }


    /**
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function isPrydz()
    {
        return $this->scrobbleClient->getRecentTracks();
    }
}