<?php

namespace App\Http\Controllers;

use App\Application\UseCase\MovieSearchUseCase;
use App\Http\Requests\MovieSearchRequest;
use App\Http\Resources\MovieResource;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function __construct(
        private MovieSearchUseCase $movieSearch
    ) {}
    
    /**
     * search
     *
     * @param  MovieSearchRequest $requrst
     * @return void
     */
    public function search(MovieSearchRequest $requrst)
    {
        $response = $this->movieSearch->execute(
            $requrst->buildQuery()
        );

        return new MovieResource($response);
    }
}
