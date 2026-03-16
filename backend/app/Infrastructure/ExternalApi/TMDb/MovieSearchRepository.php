<?php

namespace App\Infrastructure\ExternalApi\TMDb;

use App\Application\Query\MovieSearchQuery;
use App\Application\DTO\MovieSearchResultDTO;
use App\Application\Repository\MovieSearchRepositoryInterface;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

/**
 * TMDbを使用した映画検索の実装
 */
class MovieSearchRepository implements MovieSearchRepositoryInterface
{
    public function __construct(
        private MovieSearchAssembler $movieSearchAssembler
    ) {}

    /**
     * search
     *
     * @param  MovieSearchQuery $query
     * @return MovieSearchResultDTO
     */
    public function search(MovieSearchQuery $query): MovieSearchResultDTO
    {
        $uri = 'https://api.themoviedb.org/3/search/movie?query=X-MEN&include_adult=true&language=ja-JP&page=1';

        return $this->movieSearchAssembler->toDTO(
            $this->executeRequest($uri, $query->toCleanArray()),
            $this->getGenreMap()
        );
    }
    
    /**
     * ジャンルマップを取得
     * 24時間有効のキャッシュ
     *
     * @return array
     */
    private function getGenreMap(): array
    {
        return [];
    }
    
    /**
     * リクエスト実行
     *
     * @param  string $uri
     * @return void
     */
    private function executeRequest(string $uri, array $query = []): Collection
    {
        try {
            return Http::timeout(3)
                ->withToken($this->getToken())
                ->withHeaders(['accept' => 'application/json'])
                ->get($uri, $query)
                ->throw()
                ->collect();
        } catch (RequestException $e) {
            Log::error("TMDb API Error: {$uri}", ['message' => $e->getMessage()]);
            throw new RuntimeException('外部APIとの通信に失敗しました');
        }
    }
    
    /**
     * APIトークンの取得
     *
     * @return string
     */
    private function getToken(): string
    {
        $token = env('TMDB_API_TOKEN');
        if (is_null($token)) {
            throw new RuntimeException('APIトークンが見つかりません');
        }

        return $token;
    }
}