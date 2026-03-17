<?php

namespace App\Providers;

use App\Infrastructure\ExternalApi\Interface\HttpClientInterface;
use App\Infrastructure\ExternalApi\TMDb\TMDbClient;
use Illuminate\Support\ServiceProvider;

class HttpClientProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            HttpClientInterface::class,
            TMDbClient::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
