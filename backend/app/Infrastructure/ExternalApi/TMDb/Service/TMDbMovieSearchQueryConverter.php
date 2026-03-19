<?php

namespace App\Infrastructure\ExternalApi\TMDb\Service;

use App\Application\Query\MovieSearchQuery;

class TMDbMovieSearchQueryConverter
{
    /**
     * MovieSearchQuery => TMDb 
     * 異なるもののみ定義
     */
    const MOVIE_SEARCH_KEYS = [
        'title' => 'query',
    ];
    
    /**
     * 配列化
     *
     * @param  MovieSearchQuery $query
     * @return array
     */
    public function toArray(MovieSearchQuery $query): array
    {
        $q = $query->toArray();
        return $this->convert($q);
    }
    
    /**
     * 値の無い要素を除いた配列化
     *
     * @param  MovieSearchQuery $query
     * @return array
     */
    public function toCleanArray(MovieSearchQuery $query): array
    {
        $q = $query->toCleanArray();
        return $this->convert($q);
    }
    
    /**
     * 変換
     *
     * @param  array $query
     * @return array
     */
    private function convert(array $query): array
    {
        $TMDbKeys = self::MOVIE_SEARCH_KEYS;

        $q = [];
        foreach ($query as $k => $v) {
            # 値変換（boolを文字列へ）
            if (is_bool($v)) {
                $v = $v ? 'true' : 'false';
            }

            array_key_exists($k, $TMDbKeys)
                ? $q[$TMDbKeys[$k]] = $v
                : $q[$k] = $v;
        }

        return $q;
    }
}