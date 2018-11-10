<?php

namespace App\Services\LastFm;

use App\Services\LastFm\Http\ScrobbleClient;
use Carbon\Carbon;

class ScrobbleService
{
    const KEY_ARTIST = 'artist.#text';
    const KEY_TITLE = 'name';
    const KEY_ALBUM = 'album.#text';
    const KEY_URL = 'url';
    const KEY_IMAGE_LINK = 'image.3.#text';
    const KEY_IS_NOW_PLAYING = '@attr.nowplaying';
    const KEY_TIME_START = 'date.uts';

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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function checkPrydz()
    {
        $tracks = $this->scrobbleClient->getRecentTracks();
        $prydzTrackDetails = $this->getPrydzTrack($tracks);

        if($prydzTrackDetails) {
            if($this->isNowPlaying($prydzTrackDetails)) {
                return view('prydz-now', $prydzTrackDetails);
            }

            $prydzTrackDetails = array_merge($prydzTrackDetails, [
                'lastPlayed' => $this->getLastPlayed($prydzTrackDetails)
            ]);

            return view('prydz-before', $prydzTrackDetails);
        }

        return view('no-prydz');
    }


    /**
     * @param array $trackDetails
     * @return string
     */
    private function getLastPlayed(array $trackDetails)
    {
        $lastPlayed = array_get($trackDetails, 'time');
        return Carbon::createFromTimestampUTC($lastPlayed)->format('F jS\\, Y \\a\\t h:i A');
    }


    /**
     * @param array $trackDetails
     * @return bool
     */
    private function isNowPlaying(array $trackDetails)
    {
        if(array_get($trackDetails, 'nowPlaying')) {
            return true;
        }

        if($this->getMinuteDifference($trackDetails) <= 5) {
            return true;
        }

        return false;
    }


    /**
     * @param array $trackDetails
     * @return bool|int
     */
    private function getMinuteDifference(array $trackDetails)
    {
        $trackTime = array_get($trackDetails, 'time');
        if(!$trackTime) {
            return false;
        }
        $trackTime = Carbon::createFromTimestampUTC($trackTime);
        return Carbon::now()->diffInMinutes($trackTime);
    }


    /**
     * @param array $tracks
     * @return array|bool
     */
    private function getPrydzTrack(array $tracks)
    {
        foreach($tracks as $track) {
            $artist = array_get($track, self::KEY_ARTIST);
            $title = array_get($track, self::KEY_TITLE);
            $album = array_get($track, self::KEY_ALBUM);

            $trackDetails = array(
                'artist' => $artist,
                'title' => $title,
                'album' => $album
            );

            if($this->doTrackDetailsHavePrydz($trackDetails)){
                $trackDetails = array_merge($trackDetails, [
                    'url' => array_get($track, self::KEY_URL),
                    'img' => array_get($track, self::KEY_IMAGE_LINK),
                    'time' => array_get($track, self::KEY_TIME_START),
                    'nowPlaying' => array_get($track, self::KEY_IS_NOW_PLAYING)
                ]);

                return $trackDetails;
            }
        }
        return false;
    }


    /**
     * @param array $trackDetails
     * @return bool
     */
    private function doTrackDetailsHavePrydz(array $trackDetails)
    {
        $prydzIds = ['prydz', 'pryda', 'cirez d'];

        foreach($trackDetails as $key => $trackDetail) {
            foreach($prydzIds as $prydzId) {
                if(str_contains(strtolower($trackDetail), $prydzId)) {
                    return true;
                }
            }
        }
        return false;
    }
}