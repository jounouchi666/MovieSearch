<?php

namespace App\Providers;

use App\Application\Repository\MovieGenreRepositoryInterface;
use App\Application\Repository\MovieSearchRepositoryInterface;
use App\Infrastructure\ExternalApi\TMDb\MovieGenreRepository;
use App\Infrastructure\ExternalApi\TMDb\MovieSearchRepository;
use Illuminate\Support\ServiceProvider;

class MovieProvider extends ServiceProvider
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

        $this->app->bind(
            MovieGenreRepositoryInterface::class,
            MovieGenreRepository::class
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
