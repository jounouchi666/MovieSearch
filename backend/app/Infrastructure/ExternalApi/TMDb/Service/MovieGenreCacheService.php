<?php

namespace App\Infrastructure\ExternalApi\TMDb\Service;

use App\Application\Repository\MovieGenreRepositoryInterface;
use Illuminate\Support\Facades\Cache;

class MovieGenreCacheService
{
    public function __construct(
        private MovieGenreRepositoryInterface $movieGenreRepository
    ) {}

    /**
     * ジャンルマップを取得
     * 24時間有効のキャッシュ
     *
     * @return array
     */
    public function getGenreMap(): array
    {
        $key = 'tmdb_genre_' . config('tmdb.language');

        return Cache::remember(
            $key,
            86400, # 24h
            fn () => $this->movieGenreRepository->getGenre()
        );
    }
}