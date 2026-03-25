<?php

namespace Tests\Unit;

use App\Infrastructure\ExternalApi\TMDb\Service\TMDbMovieSearchMapper;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class TMDbMovieSearchMapperTest extends TestCase
{
    /**
     * 正常系
     */
    public function test_APIレスポンスがDTOに変換される(): void
    {
        Config::set('tmdb.image_base_url', 'https://img.test');

        $mapper = new TMDbMovieSearchMapper();

        $response = [
            'page' => 1,
            'results' => [
                [
                    'id' => 1,
                    'title' => 'test',
                    'genre_ids' => [28],
                    'poster_path' => '/abc.jpg'
                ]
            ],
            'total_pages' => 10,
            'total_results' => 100
        ];

        $genreMap = [28 => 'action'];

        $dto = $mapper->toDTO($response, $genreMap);

        $this->assertEquals('test', $dto->results[0]->title);
        $this->assertEquals('action', $dto->results[0]->genre[0]->name);
        $this->assertStringContainsString('/abc.jpg', $dto->results[0]->posterPath);
    }

    /**
     * 異常系
     */
    public function test_レスポンスにキーがなくても落ちない(): void
    {
        Config::set('tmdb.image_base_url', 'https://img.test');

        $mapper = new TMDbMovieSearchMapper();

        $dto = $mapper->toDTO([], []);

        $this->assertEquals(1, $dto->page);
        $this->assertEmpty($dto->results);
    }
}
