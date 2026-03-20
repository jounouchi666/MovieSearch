import type { Movie } from "../types/movie"
import MovieItem from "./MovieItem"
import Pagination from "./Pagination";

type Props = {
    movies: Movie[] | null;
    count: number;
    page: number;
    totalPages: number; 
    onPagination: (page: number) => void;
}

const MovieList = ({ movies, count, page, totalPages, onPagination }: Props) => {
    if (movies === null) return null;                   // 未検索時
    if (count === 0) return <p>検索結果がありません</p>;  // 検索結果0

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