<?php

namespace Tests\Unit;

use App\Application\Query\MovieSearchQuery;
use PHPUnit\Framework\TestCase;

class MovieSearchQueryTest extends TestCase
{
    /**
     * toArray()
     */
    public function test_toArrayですべての値が配列化される(): void
    {
        $query = new MovieSearchQuery(
            title: 'test',
            includeAdult: false,
            year: 2000,
            page: 1
        );

        $result = $query->toArray();

        $this->assertEquals([
            'title' => 'test',
            'include_adult' => false,
            'year' => 2000,
            'page' => 1
        ], $result);
    }

    /**
     * toQueryArray()
     */
    public function test_nullは除外される(): void
    {
        $query = new MovieSearchQuery(
            title: 'test',
            includeAdult: false,
            year: null,
            page: 1
        );

        $result = $query->toCleanArray();

        $this->assertEquals([
            'title' => 'test',
            'include_adult' => false,
            'page' => 1
        ], $result);
    }

    public function test_falseは除外されない(): void
    {
        $query = new MovieSearchQuery(
            title: 'test',
            includeAdult: false,
            year: null,
            page: 1
        );

        $result = $query->toCleanArray();

        $this->assertArrayHasKey('include_adult', $result);
        $this->assertFalse($result['include_adult']);
    }

    public function test_空文字は除外される(): void
    {
        $query = new MovieSearchQuery(
            title: '',
            includeAdult: false,
            year: null,
            page: 1
        );

        $result = $query->toCleanArray();

        $this->assertArrayNotHasKey('title', $result);
    }
}
