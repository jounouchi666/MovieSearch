import { useState } from "react";

type Props = {
    onSearch: (title: string, includeAdult: boolean, page: number) => void;
    loading: boolean;
}

const SearchForm = ({ onSearch, loading}: Props) => {
    const [title, setTitle] = useState('');
    const [includeAdult, setIncludeAdult] = useState(false);

    const submit = (e: React.FormEvent) => {
        e.preventDefault();
        if (loading) return;
        if (!title.trim()) return;
        onSearch(title, includeAdult, 1);
    };

    return (
        <form className="mt-5 flex justify-center" onSubmit={submit}>
            <div className="max-w-full flex flex-col gap-2">
                <div className="flex gap-3">
                    <input
                        className="w-md border-color-white outline-slate-300 shadow-sm rounded p-2"
                        type="text"
                        name="title"
                        value={title}
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
                <label className="w-full flex items-center gap-2 text-sm text-gray-600">
                    <input
                        type="checkbox"
                        checked={includeAdult}
                        onChange={() => setIncludeAdult(!includeAdult)}
                    />
                        成人向け作品を含める
                </label>
            </div>
        </form>
    );
}

export default SearchForm;