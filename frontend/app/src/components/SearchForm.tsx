import { useState } from "react";
import type { ValidationError } from "../types/validationError";
import ErrorMessage from "./ErrorMessage";

type Props = {
    onSearch: (title: string, includeAdult: boolean, page: number) => void;
    titleInUrl: string;
    includeAdultInUrl: boolean;
    loading: boolean;
    validationErrors: ValidationError['errors']|null;
}

const SearchForm = ({ onSearch, titleInUrl, includeAdultInUrl, loading, validationErrors}: Props) => {
    const [title, setTitle] = useState(titleInUrl);
    const [includeAdult, setIncludeAdult] = useState(includeAdultInUrl);

    const submit = (e: React.FormEvent) => {
        e.preventDefault();
        if (loading) return;
        if (!title.trim()) return;
        onSearch(title, includeAdult, 1);
    };

    return (
        <form className="mt-5 flex justify-center" onSubmit={submit}>
            <div className="max-w-full flex flex-col gap-2">
                <div className="flex flex-col gap-1">
                    <div className="flex gap-3">
                        <input
                            className="w-md border-color-white outline-slate-300 shadow-sm rounded p-2"
                            type="text"
                            name="title"
                            value={title}
                            maxLength={255}
                            onChange={e => setTitle(e.target.value)}
                            placeholder="タイトルを入力"
                        />
                        <button
                            className="shrink-0 border rounded shadow-sm text-white py-2 w-24 bg-cyan-500 transition-colors cursor-pointer hover:bg-cyan-600"
                            type="submit"
                            disabled={loading}
                        >
                            検索   
                        </button>
                    </div>
                    <div>
                        {validationErrors?.['title'] &&
                            <ErrorMessage messages={validationErrors['title']}/>
                        }
                    </div>
                </div>
                
                <div className="flex flex-col gap-1">
                    <label className="w-full flex items-center gap-2 text-sm text-gray-600">
                    <input
                        type="checkbox"
                        checked={includeAdult}
                        onChange={() => setIncludeAdult(!includeAdult)}
                    />
                        成人向け作品を含める
                    </label>
                    {validationErrors?.['include_adult'] &&
                        <ErrorMessage messages={validationErrors['include_adult']}/>
                    }
                </div>
            </div>
        </form>
    );
}

export default SearchForm;