import type { Movie } from "../types/movie"

type Props = {
    movie: Movie
}

const MovieItem = ({ movie }: Props) => {
    const releaseDate = new Date(movie.release_date);
    const poster = movie.poster_path ?? '/no_image.png'

    return (
        <li className="flex justify-between items-start gap-6">
            <div className="p-1 rounded shadow-sm w-full flex gap-3">
                <div className="w-[150px] shrink-0">
                    <img
                        className="w-full"
                        src={poster}
                        alt={`${movie.title}のポスター`}
                        loading="lazy"
                    />
                </div>
                <div>
                    <p className="text-xl font-bold">{movie.title}</p>
                    <p>原題：{movie.original_title}</p>
                    <p>{Number.isNaN(releaseDate.getFullYear()) ? '公開日未定' : `${releaseDate.getFullYear()}年公開`}</p>
                    {movie.overview && (
                        <div className="mt-1">
                            <h3>あらすじ</h3>
                            <p>{movie.overview}</p>
                        </div>
                    )}
                </div>
            </div>
        </li>
    );
}

export default MovieItem;