import type { Movie } from "../types/movie";
import MovieItem from "./MovieItem";

type Props = {
    movies: Movie[];
}

const MovieList = ({ movies }: Props) => {
    return (
        <div className="flex-1 overflow-y-auto mt-4">
            <ul className="mt-5 p-3 flex flex-col gap-3">
                {movies.map(movie =>
                    <MovieItem key={movie.id} movie={movie}/>
                )}
            </ul>
        </div>
    );
}

export default MovieList;