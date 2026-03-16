<?php

namespace App\Application\UseCase;

use App\Application\DTO\MovieSearchResultDTO;
use App\Application\Query\MovieSearchQuery;
use App\Application\Repository\MovieSearchRepositoryInterface;

class MovieSearchUseCase
{
    public function __construct(
        private MovieSearchRepositoryInterface $movieSearchRepository
    ) {}

    public function execute(MovieSearchQuery $query): MovieSearchResultDTO
    {
        return $this->movieSearchRepository->search($query);
    }
}