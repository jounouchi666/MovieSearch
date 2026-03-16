<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'original_title' => $this->originalTitle,
            'genre' => MovieGenreResource::collection($this->genre),
            'overview' => $this->overview,
            'poster_path' => $this->posterPath,
            'backdrop_path' => $this->backdropPath,
            'adult' => $this->adult,
            'release_date' => $this->releaseDate,
        ];
    }
}
