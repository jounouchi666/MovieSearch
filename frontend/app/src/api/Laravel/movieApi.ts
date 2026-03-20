import type { MovieResponse } from "../../types/movie";
import { laravelFetch, SEARCH_URL } from "./laravelClient";

export const searchMovies = async (title: string, includeAdult: boolean, page: number): Promise<MovieResponse> => {
    const url = `${SEARCH_URL}?title=${encodeURIComponent(title)}&include_adult=${includeAdult ? 1 : 0}&page=${page}`;
    console.log(url);
    return laravelFetch(url);
}