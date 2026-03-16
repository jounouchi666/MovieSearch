<?php

namespace App\Application\Repository;

use App\Application\DTO\MovieSearchResultDTO;
use App\Application\Query\MovieSearchQuery;

interface MovieSearchRepositoryInterface
{
    public function search(MovieSearchQuery $query): MovieSearchResultDTO;
}