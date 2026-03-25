<?php

namespace Tests\Unit;

use App\Application\Repository\MovieGenreRepositoryInterface;
use App\Infrastructure\ExternalApi\TMDb\Service\MovieGenreCacheService;
use Illuminate\Support\Facades\Cache;
use Mockery;
use Tests\TestCase;

class MovieGenreCacheServiceTest extends TestCase
{
    /**
     * 正常系
     */
    public function test_キャッシュされる(): void
    {
        Cache::spy();

        $repo = Mockery::mock(MovieGenreRepositoryInterface::class);
        $repo->shouldReceive('getGenre')
            ->once()
            ->andReturn([28 => 'action']);

        $service = new MovieGenreCacheService($repo);

        $service->getGenreMap();
        $service->getGenreMap(); // 2回目は呼ばれないことを確認
    }
}
