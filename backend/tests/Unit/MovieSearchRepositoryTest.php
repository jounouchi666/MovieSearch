<?php

namespace Tests\Unit;

use App\Application\DTO\MovieSearchResultDTO;
use App\Application\Query\MovieSearchQuery;
use App\Infrastructure\ExternalApi\TMDb\MovieSearchRepository;
use App\Infrastructure\ExternalApi\TMDb\Service\MovieGenreCacheService;
use App\Infrastructure\ExternalApi\TMDb\Service\TMDbMovieSearchMapper;
use App\Infrastructure\ExternalApi\TMDb\Service\TMDbMovieSearchQueryConverter;
use App\Infrastructure\ExternalApi\TMDb\Service\TMDbRequestExecutor;
use Illuminate\Support\Facades\Config;
use Mockery;
use PHPUnit\Framework\TestCase;

class MovieSearchRepositoryTest extends TestCase
{
    /**
     * 正常系
     */
    public function test_各サービスを組み合わせてDTOを返す(): void
    {
        Config::set('tmdb.search_url', 'https://test/search');

        $query = new MovieSearchQuery('test', true, null, 1);

        $converter = Mockery::mock(TMDbMovieSearchQueryConverter::class);
        $executor = Mockery::mock(TMDbRequestExecutor::class);
        $mapper = Mockery::mock(TMDbMovieSearchMapper::class);
        $genreService = Mockery::mock(MovieGenreCacheService::class);

        $converted = ['query' => 'test'];
        $apiResponse = ['results' => []];
        $genreMap = [28 => 'action'];
        $dto = new MovieSearchResultDTO(1, [], 1, 0);

        $converter->shouldReceive('toCleanArray')
            ->once()
            ->with($query)
            ->andReturn($converted);

        $executor->shouldReceive('executeRequest')
            ->once()
            ->andReturn($apiResponse);

        $genreService->shouldReceive('getGenreMap')
            ->once()
            ->andReturn($genreMap);

        $mapper->shouldReceive('toDTO')
            ->once()
            ->with($apiResponse, $genreMap)
            ->andReturn($dto);

        $repo = new MovieSearchRepository(
            $mapper,
            $genreService,
            $converter,
            $executor
        );

        $result = $repo->search($query);

        $this->assertSame($dto, $result);
    }
}
