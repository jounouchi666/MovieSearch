<?php

namespace App\Infrastructure\ExternalApi\Interface;

interface HttpClientInterface
{
    /**
     * GETリクエスト実行
     *
     * @param  string $uri
     * @return array
     */
    public function get(string $uri, array $query = []): array;
}