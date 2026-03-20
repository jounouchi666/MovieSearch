import { useState } from "react";
import SearchForm from "../components/SearchForm"
import type { Movie, Param } from "../types/movie";
import { searchMovies } from "../api/Laravel/movieApi";
import Loading from "../components/Loading";
import ErrorMessage from "../components/ErrorMessage";
import MovieList from "../components/MovieList";

export const Search = () => {
    const [movies, setMovies] = useState<Movie[]|null>(null)
    const [page, setPage] = useState<number>(0);
    const [totalPages, setTotalPages] = useState<number>(0);
    const [totalResults, setTotalResults] = useState<number>(0);
    const [currentParam, setCurrentParam] = useState<Param>({title: '', includeAdult: false});
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState('');

    const onSearch = (title: string, includeAdult: boolean) => {
        setCurrentParam({title, includeAdult});
        loadMovies(title, includeAdult, 1);
    };

    const loadMovies = async (title: string, includeAdult: boolean, page: number) => {
        try {
            setError('');
            setLoading(true);

            const data = await searchMovies(title, includeAdult, page);

            setPage(data.page);
            setMovies(data.results);
            setTotalPages(data.total_pages);
            setTotalResults(data.total_results);
        } catch {
            setError('読み込み失敗');
        } finally {
            setLoading(false);
        }
    };

    const pagination = (page: number) => {
        loadMovies(currentParam.title, currentParam.includeAdult, page);
    }

    return (
        <div className="w-full max-h-[90vh] md:max-h-[90vh] px-3 py-6 md:max-w-7xl md:w-auto md:p-6 md:shadow-md md:rounded bg-white flex flex-col">
            <h1 className="text-xl md:text-3xl font-bold text-center">Movie Search</h1>
            <SearchForm onSearch={onSearch} loading={loading} />

            {movies !== null &&
                <p className="mt-4 text-right">検索結果：{totalResults}件</p>
            }

            {loading && <Loading />}
            {error && <ErrorMessage message={error}/>}

            {!loading && !error &&
                <MovieList
                count={totalResults}
                movies={movies}
                page={page}
                totalPages={totalPages}
                onPagination={pagination}
                />
            }
        </div>
    );
}