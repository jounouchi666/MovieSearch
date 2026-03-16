<?php

namespace App\Application\DTO;

final class MovieGenreResultDTO
{
    public function __construct(
        public int $id,
        public string $title
    ) {}
}