<?php

namespace Tests\Unit;

use App\Infrastructure\ExternalApi\Interface\HttpClientInterface;
use App\Infrastructure\ExternalApi\TMDb\Exception\TMDbApiException;
use App\Infrastructure\ExternalApi\TMDb\Service\TMDbRequestExecutor;
use Illuminate\Http\Client\RequestException;
use Mockery;
use PHPUnit\Framework\TestCase;

class TMDbRequestExecutorTest extends TestCase
{
    /**
     * 正常系
     */
    public function test_HTTPクライアントの結果を返す(): void
    {
        $client = Mockery::mock(HttpClientInterface::class);
        $client->shouldReceive('get')
            ->once()
            ->andReturn(['ok' => true]);

        $executor = new TMDbRequestExecutor($client);

        $result = $executor->executeRequest('url');

        $this->assertEquals(['ok' => true], $result);
    }

    /**
     * 異常系
     */
    public function test_RequestExceptionが独自例外に変換される(): void
    {
        $psr = new \GuzzleHttp\Psr7\Response(500, [], json_encode([]));
        $response = new \Illuminate\Http\Client\Response($psr);

        $client = Mockery::mock(HttpClientInterface::class);
        $client->shouldReceive('get')
            ->andThrow(new RequestException($response));

        $executor = new TMDbRequestExecutor($client);

        $this->expectException(TMDbApiException::class);

        $executor->executeRequest('url');
    }
}
