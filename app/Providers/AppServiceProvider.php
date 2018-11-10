<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\LastFm\Http\ApiClient as LastFmApiClient;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(LastFmApiClient::class, function() {
            $apiClientConfig =[];
            $apiClientConfig['base_uri'] = config('services.last_fm.api_base_uri');
            return new LastFmApiClient($apiClientConfig);
        });
    }
}
