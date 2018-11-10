<?php

namespace App\Http\Controllers;

use App\Services\LastFm\ScrobbleService;

class HomeController extends Controller
{
    /** @var ScrobbleService $scrobbleService */
    private $scrobbleService;

    public function __construct(ScrobbleService $scrobbleService)
    {
        $this->scrobbleService = $scrobbleService;
    }

    public function show()
    {
        $this->scrobbleService->isPrydz();
    }
}