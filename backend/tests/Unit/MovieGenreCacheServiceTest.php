<?php

namespace Tests\Unit;

use App\Application\Repository\MovieGenreRepositoryInterface;
use App\Infrastructure\ExternalApi\TMDb\Service\MovieGenreCacheService;
use Illuminate\Support\Facades\Cache;
use Mockery;
use PHPUnit\Framework\TestCase;

class MovieGenreCacheServiceTest extends TestCase
{
    /**
     * 正常系
     */
    public function test_キャッシュされる(): void
    {
        Cache::shouldReceive('remember')
            ->once()
            ->andReturn([28 => 'action']);

        $repo = Mockery::mock(MovieGenreRepositoryInterface::class);

        $service = new MovieGenreCacheService($repo);

        $result = $service->getGenreMap();

        $this->assertEquals([28 => 'action'], $result);
    }
}
