import { useEffect, useState } from "react";
import SearchForm from "../components/SearchForm"
import type { Movie } from "../types/movie";
import { searchMovies } from "../api/Laravel/movieApi";
import Loading from "../components/Loading";
import ErrorMessage from "../components/ErrorMessage";
import MovieList from "../components/MovieList";
import { useSearchParams } from "react-router-dom";
import type { ValidationError } from "../types/validationError";
import axios from "axios";
import Pagination from "../components/Pagination";

export const Search = () => {
    const [searchParams, setSearchParams] = useSearchParams();

    const titleInUrl = searchParams.get('title') || '';
    const includeAdultInUrl = searchParams.get('includeAdult') === 'true';
    const pageParam = searchParams.get('page');
    const pageInUrl = pageParam ? parseInt(pageParam, 10) : 1;

    const [title, setTitle] = useState('');
    const [includeAdult, setIncludeAdult] = useState(false);
    const [hasSearched, setHasSearched] = useState(false);
    const [movies, setMovies] = useState<Movie[]>([]);
    const [totalPages, setTotalPages] = useState<number>(0);
    const [totalResults, setTotalResults] = useState<number>(0);
    const [validationErrors, setValidationErrors] = useState<ValidationError['errors']|null>(null);
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState<string|null>(null);

    useEffect(() => {
        setTitle(titleInUrl);
        setIncludeAdult(includeAdultInUrl);
    }, [titleInUrl, includeAdultInUrl])

    useEffect(() => {
        if (!title) return;

        const controller = new AbortController();

        const loadMovies = async () => {
            try {
                setValidationErrors(null);
                setError(null);
                setLoading(true);

                const data = await searchMovies({
                    title,
                    includeAdult,
                    page: pageInUrl
                });

                setHasSearched(true);
                setMovies(data.data.results);
                setTotalPages(data.data.total_pages);
                setTotalResults(data.data.total_results);
            } catch (err: unknown) {
                if (axios.isAxiosError(err)) {
                    if (err.response?.status === 422) {
                        setValidationErrors(err.response.data.errors);
                        setError('入力内容を確認してください');
                    } else {
                        setError('読み込み失敗');
                    }
                } else {
                    setError('予期しないエラー');
                }
            } finally {
                setLoading(false);
            }
        };

        loadMovies();

        return () => controller.abort();
    }, [title, includeAdult, pageInUrl]);

    const onSearch = (newTitle: string, newIncludeAdult: boolean) => {
        setSearchParams({title: newTitle, includeAdult: String(newIncludeAdult), page: '1'})
    };
    

    const pagination = (newPage: number) => {
        setSearchParams({title, includeAdult: String(includeAdult), page: String(newPage)});
    }

    return (
        <div className="w-full max-h-[90vh] md:max-h-[90vh] px-3 py-6 md:max-w-7xl md:w-auto md:p-6 md:shadow-md md:rounded bg-white flex flex-col">
            <h1 className="text-xl md:text-3xl font-bold text-center">Movie Search</h1>
            <SearchForm
                onSearch={onSearch}
                titleInUrl={title}
                includeAdultInUrl={includeAdult}
                loading={loading}
                validationErrors={validationErrors}
            />

            {error && <ErrorMessage messages={error}/>}

            {loading && <Loading />}

            {!loading && !error && !validationErrors && hasSearched &&
                <p className="mt-4 text-right">検索結果：{totalResults}件</p>
            }
            
            {!loading && !error && !validationErrors && hasSearched && totalResults === 0 &&
                <p>検索結果がありません</p>
            }

            {!loading && !error && !validationErrors && hasSearched && totalResults > 0 &&
                <>
                    <MovieList movies={movies} />
                    <div className="flex justify-center">
                        <Pagination page={pageInUrl} totalPages={totalPages} onPagination={pagination} />
                    </div>
                </>
            }           
        </div>
    );
}