<?php

namespace Tests\Unit;

use App\Application\Query\MovieSearchQuery;
use App\Infrastructure\ExternalApi\TMDb\Service\TMDbMovieSearchQueryConverter;
use PHPUnit\Framework\TestCase;

class TMDbMovieSearchQueryConverterTest extends TestCase
{
    /**
     * 正常系
     */
    public function test_titleがqueryに変換される(): void
    {
        $converter = new TMDbMovieSearchQueryConverter();

        $query = new MovieSearchQuery('test', true, null, 1);

        $result = $converter->toArray($query);

        $this->assertArrayHasKey('query', $result);
    }

    public function test_boolが文字列に変換される(): void
    {
        $converter = new TMDbMovieSearchQueryConverter();

        $query = new MovieSearchQuery('test', true, null, 1);

        $result = $converter->toArray($query);

        $this->assertEquals('true', $result['include_adult']);
    }
}
