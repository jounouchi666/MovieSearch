<?php

namespace Tests\Feature;

use App\Application\DTO\MovieSearchResultDTO;
use App\Application\Query\MovieSearchQuery;
use App\Application\Repository\MovieSearchRepositoryInterface;
use App\Application\UseCase\MovieSearchUseCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery;
use Tests\TestCase;

class MovieSearchUseCaseTest extends TestCase
{
    /**
     * 正常系
     */
    public function test_Repositoryのsearchが呼ばれて結果が返る(): void
    {
        $repo = Mockery::mock(MovieSearchRepositoryInterface::class);

        $dummyResult = new MovieSearchResultDTO(
            page: 1,
            results: [],
            totalPages: 1,
            totalResults: 0,
        );

        $query = new MovieSearchQuery(
            title: 'test',
            includeAdult: false,
            year: 2000,
            page: 1
        );

        $repo
            ->shouldReceive('search')
            ->once()
            ->with($query)
            ->andReturn($dummyResult);

        $useCase = new MovieSearchUseCase($repo);

        $result = $useCase->execute($query);

        $this->assertSame($dummyResult, $result);
    }
}
