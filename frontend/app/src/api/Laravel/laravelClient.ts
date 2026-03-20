// URL
export const BASE_URL = 'http://localhost:80';
export const SEARCH_URL = BASE_URL + '/api/v1/search';

const options = {
    method: 'GET',
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-API-Version': '1.0'
    }
};

export const laravelFetch = async <T>(url:string): Promise<T> => {
    const res = await fetch(url, options);
    if (!res.ok) {
        throw new Error('Failed to fetch movies');
    }

    const data = await res.json();
    return data.data;
}