<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class MovieSearchRequestTest extends TestCase
{
    /**
     * 共通
     */
    public function test_最小パラメータでOK(): void
    {
        $response = $this->getJson("/api/search?title=test");

        $this->assertSuccessResponse($response);
    }

    /**
     * title
     */
    public function test_titleが空でNG(): void
    {
        $response = $this->getJson('/api/search');

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['title']);
    }

    public function test_titleが255文字でOK(): void
    {
        $title = str_repeat('a', 255);

        $response = $this->getJson("/api/search?title={$title}");

        $this->assertSuccessResponse($response);
    }

    public function test_titleが255文字超えでNG(): void
    {
        $title = str_repeat('a', 256);

        $response = $this->getJson("/api/search?title={$title}");

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['title']);
    }

    /**
     * include_adult
     */
    public function test_include_adultがtrueでOK(): void
    {
        $includeAdult = true;

        $response = $this->getJson("/api/search?title=test&include_adult={$includeAdult}");

        $response->assertOk()
            ->assertJson(fn ($json) => $json->has('data')->etc());
    }

    public function test_include_adultが不正な値（文字列）でNG(): void
    {
        $includeAdult = 'ofCourse';

        $response = $this->getJson("/api/search?title=test&include_adult={$includeAdult}");

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['include_adult']);
    }

    /**
     * year
     */

    public function test_yearが不正な値（文字列）でNG(): void
    {
        $year = 'h30';

        $response = $this->getJson("/api/search?title=test&year={$year}");

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['year']);
    }

    public function test_yearが4桁未満でNG(): void
    {
        $year = 190;

        $response = $this->getJson("/api/search?title=test&year={$year}");

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['year']);
    }

    public function test_yearが最小値でOK(): void
    {
        $year = 1900;

        $response = $this->getJson("/api/search?title=test&year={$year}");

        $response->assertOk()
            ->assertJson(fn ($json) => $json->has('data')->etc());
    }

    public function test_yearが最小値未満でNG(): void
    {
        $year = 1899;

        $response = $this->getJson("/api/search?title=test&year={$year}");

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['year']);
    }

    public function test_yearが最大値でOK(): void
    {
        $year = date('Y') + 5;

        $response = $this->getJson("/api/search?title=test&year={$year}");

        $response->assertOk()
            ->assertJson(fn ($json) => $json->has('data')->etc());
    }

    public function test_yearが最大値超過でNG(): void
    {
        $year = date('Y') + 6;

        $response = $this->getJson("/api/search?title=test&year={$year}");

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['year']);
    }

    /**
     * page
     */
    public function test_pageが最小値でOK(): void
    {
        $page = 1;

        $response = $this->getJson("/api/search?title=test&page={$page}");

        $response->assertOk()
            ->assertJson(fn ($json) => $json->has('data')->etc());
    }

    public function test_pageが最小値未満でNG(): void
    {
        $page = 0;

        $response = $this->getJson("/api/search?title=test&page={$page}");

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['page']);
    }

    public function test_pageが不正な値（文字列）でNG(): void
    {
        $page = 'first';

        $response = $this->getJson("/api/search?title=test&page={$page}");

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['page']);
    }

        
    /**
     * 成功レスポンス
     *
     * @param  TestResponse $response
     * @return void
     */
    private function assertSuccessResponse(TestResponse $response): void
    {
        $response->assertOk()
            ->assertJson(fn ($json) => $json->has('data'));
    }
}
