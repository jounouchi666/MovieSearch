import type { MovieResponse } from "../../types/movie";
import LaravelClient from "./LaravelClient";

type Query = {
    title: string;
    includeAdult: boolean;
    page: number;
    signal: AbortSignal;
}

const SEARCH_URL = '/api/v1/search';

export const searchMovies = async ({title, includeAdult, page, signal}: Query): Promise<MovieResponse> => {
    const params = {
        title,
        include_adult: includeAdult,
        page
    };
    const client = LaravelClient.getInstance();
    return await client.get<MovieResponse>(SEARCH_URL, params, signal);
}