<?php

namespace Tests\Unit;

use App\Infrastructure\ExternalApi\TMDb\MovieGenreRepository;
use App\Infrastructure\ExternalApi\TMDb\Service\TMDbRequestExecutor;
use Mockery;
use PHPUnit\Framework\TestCase;

class MovieGenreRepositoryTest extends TestCase
{
    /**
     * 正常系
     */
    public function test_genre配列がid_nameマップになる(): void
    {
        $executor = Mockery::mock(TMDbRequestExecutor::class);
        $executor->shouldReceive('executeRequest')
            ->once()
            ->andReturn([
                'genres' => ['id' => 28, 'name' => 'action']
            ]);

        $repo = new MovieGenreRepository($executor);

        $result = $repo->getGenre();

        $this->assertEquals(['28' => 'action'], $result);
    }
}
