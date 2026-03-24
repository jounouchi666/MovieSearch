<?php

namespace App\Infrastructure\ExternalApi\TMDb;

use App\Application\Query\MovieSearchQuery;
use App\Application\DTO\MovieSearchResultDTO;
use App\Application\Repository\MovieSearchRepositoryInterface;
use App\Infrastructure\ExternalApi\TMDb\Service\MovieGenreCacheService;
use App\Infrastructure\ExternalApi\TMDb\Service\TMDbMovieSearchMapper;
use App\Infrastructure\ExternalApi\TMDb\Service\TMDbMovieSearchQueryConverter;
use App\Infrastructure\ExternalApi\TMDb\Service\TMDbRequestExecutor;

/**
 * TMDbを使用した映画検索の実装
 */
class MovieSearchRepository implements MovieSearchRepositoryInterface
{
    public function __construct(
        private TMDbMovieSearchMapper $TMDbMovieSearchMapper,
        private MovieGenreCacheService $movieGenreCacheService,
        private TMDbMovieSearchQueryConverter $tmdbMovieSearchQueryComverter,
        private TMDbRequestExecutor $tmdbRequestExecutor
    ) {}

    /**
     * search
     *
     * @param  MovieSearchQuery $query
     * @return MovieSearchResultDTO
     */
    public function search(MovieSearchQuery $query): MovieSearchResultDTO
    {
        return $this->TMDbMovieSearchMapper->toDTO(
            $this->tmdbRequestExecutor->executeRequest(
                config('tmdb.search_url'),
                [
                    ...$this->tmdbMovieSearchQueryComverter->toCleanArray($query),
                    'language' => config('tmdb.language')
                ]
            ),
            $this->movieGenreCacheService->getGenreMap()
        );
    }
}