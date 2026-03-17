<?php

namespace App\Infrastructure\ExternalApi\TMDb\Service;

use App\Infrastructure\Exception\TMDbApiException;
use App\Infrastructure\ExternalApi\Interface\HttpClientInterface;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Log;

class TMDbRequestExecutor
{
    public function __construct(
        private HttpClientInterface $httpClient
    ) {}

    /**
     * リクエスト実行
     * エラーハンドリング付きラッパー
     *
     * @param  string $uri
     * @return array
     */
    public function executeRequest(string $uri, array $query = []): array
    {
        try {
            return $this->httpClient->get($uri, $query);
        } catch (RequestException $e) {
            Log::error('TMDb API Error', [
                    'uri' => $uri,
                    'query' => $query,
                    'message' => $e->getMessage()
            ]);
            throw new TMDbApiException(
                "TMDb API Error: {$e->getMessage()}",
                $e->getCode(),
                $e
            );
        }
    }
}