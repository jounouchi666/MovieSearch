import type { MovieResponse } from "../../types/movie";
import LaravelClient from "./LaravelClient";

type Query = {
    title: string;
    includeAdult: boolean;
    page: number;
}

const SEARCH_URL = '/api/v1/search';

export const searchMovies = async ({title, includeAdult, page}: Query): Promise<MovieResponse> => {
    const params = {
        title,
        include_adult: includeAdult ? 1 : 0,
        page
    };
    return await LaravelClient.get<MovieResponse>(SEARCH_URL, params);
}