<?php

namespace App\Infrastructure\ExternalApi\TMDb;

use App\Application\Repository\MovieGenreRepositoryInterface;
use App\Infrastructure\ExternalApi\TMDb\Service\TMDbRequestExecutor;

class MovieGenreRepository implements MovieGenreRepositoryInterface
{
    public function __construct(
        private TMDbRequestExecutor $tmdbRequestExecutor
    ) {}

    /**
     * ジャンルマップを取得
     *
     * @return array
     */
    public function getGenre(): array
    {
        $data = $this->tmdbRequestExecutor->executeRequest(
                config('tmdb.genre_url'),
                [
                    'language' => config('tmdb.language')
                ]
            );
        return collect($data['genres'])->pluck('name', 'id')->toArray();
    }
}