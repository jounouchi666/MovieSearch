<?php

namespace App\Application\Query;

final class MovieSearchQuery
{
    private function __construct(
        public string $title,
        public bool $includeAdult,
        public ?int $year,
        public int $page
    ) {}

    /**
     * 配列化
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'include_adult' => $this->includeAdult,
            'year' => $this->year,
            'page' => $this->page
        ];
    }

    public function toCleanArray(): array
    {
        return collect($this->toArray())
            ->filter(fn ($value) => filled($value))
            ->all();
    }
}