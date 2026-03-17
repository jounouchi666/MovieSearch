<?php

$baseUrl = 'https://api.themoviedb.org/3';

return [
    # Config
    'api_token' => env('TMDB_API_TOKEN'),
    'timeout' => 5,
    'language' => 'ja-JP',

    # URL
    'base_url' => $baseUrl,
    'search_url' => $baseUrl . '/search/movie',
    'genre_url' => $baseUrl . '/genre/movie/list',
    'image_base_url' => 'http://image.tmdb.org/t/p',

];