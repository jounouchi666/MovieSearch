<?php

namespace App\Infrastructure\ExternalApi\TMDb;

use App\Infrastructure\ExternalApi\Interface\HttpClientInterface;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class TMDbClient implements HttpClientInterface
{
    /**
     * GETリクエスト実行
     *
     * @param  string $uri
     * @return array
     */
    public function get(string $uri, array $query = []): array
    {
        return Http::timeout(config('tmdb.timeout'))
            ->withToken($this->getToken())
            ->withHeaders(['accept' => 'application/json'])
            ->get($uri, $query)
            ->throw()
            ->json();
    }

    /**
     * APIトークンの取得
     *
     * @return string
     */
    private function getToken(): string
    {
        $token = config('tmdb.api_token');
        if (is_null($token)) {
            throw new RuntimeException('APIトークンが見つかりません');
        }

        return $token;
    }
}