import type { Movie } from "../types/movie"
import MovieItem from "./MovieItem"
import Pagination from "./Pagination";

type Props = {
    movies: Movie[];
    page: number;
    totalPages: number; 
    onPagination: (page: number) => void;
}

const MovieList = ({ movies, page, totalPages, onPagination }: Props) => {
    return (
        <>
            <div className="flex-1 overflow-y-auto mt-4">
                <ul className="mt-5 p-3 flex flex-col gap-3">
                    {movies.map(movie =>
                        <MovieItem key={movie.id} movie={movie}/>
                    )}
                </ul>
            </div>
            <div className="flex justify-center">
                <Pagination page={page} totalPages={totalPages} onPagination={onPagination} />
            </div>
        </>
    );
}

export default MovieList;