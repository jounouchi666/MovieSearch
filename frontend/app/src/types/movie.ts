export type Movie = {
    id: number;
    title: string;
    original_title: string;
    overview: string;
    poster_path: string | null;
    release_date: string
}

export type MovieResponse = {
    data: {
        page: number;
        results: Movie[];
        total_pages: number;
        total_results: number;
    }
}

export type Param = {
    title: string;
    includeAdult: boolean;
}