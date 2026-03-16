<?php

namespace App\Providers;

use App\Application\Repository\MovieSearchRepositoryInterface;
use App\Infrastructure\ExternalApi\TMDb\MovieSearchRepository;
use Illuminate\Support\ServiceProvider;

class MovieSearchProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            MovieSearchRepositoryInterface::class,
            MovieSearchRepository::class
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
