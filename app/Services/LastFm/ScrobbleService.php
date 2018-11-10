<?php

namespace App\Services\LastFm;

use App\Services\LastFm\Http\ScrobbleClient;

class ScrobbleService
{
    const KEY_ARTIST = 'artist.#text';
    const KEY_TITLE = 'name';
    const KEY_ALBUM = 'album.#text';

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
     * @return array
     */
    public function checkPrydz()
    {
        $tracks = $this->scrobbleClient->getRecentTracks();
        $prydzTrackDetails = $this->getPrydzTrack($tracks);

        if($prydzTrackDetails) {
            return view('prydz-before', $prydzTrackDetails); // return prydz view
        }

        // return non prydz view
    }

    private function getPrydzTrack(array $tracks)
    {
        foreach($tracks as $track) {
            $artist = strtolower(array_get($track, self::KEY_ARTIST));
            $title = strtolower(array_get($track, self::KEY_TITLE));
            $album = strtolower(array_get($track, self::KEY_ALBUM));

            $trackDetails = array(
                'artist' => $artist,
                'title' => $title,
                'album' => $album
            );

            if($this->doTrackDetailsHavePrydz($trackDetails)){
                return $trackDetails;
            }
        }
        return false;
    }

    private function doTrackDetailsHavePrydz(array $trackDetails)
    {
        $prydzIds = ['prydz', 'pryda', 'cirez d'];

        foreach($trackDetails as $key => $trackDetail) {
            foreach($prydzIds as $prydzId) {
                if(str_contains($trackDetail, $prydzId)) {
                    return true;
                }
            }
        }
        return false;
    }
}