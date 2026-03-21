import axios, { type AxiosInstance } from "axios";

const BASE_URL = import.meta.env.VITE_LARAVEL_API_URL;

class LaravelClient
{
    private static instance: LaravelClient
    private axiosInstance: AxiosInstance;

    private readonly HEADERS = {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-API-Version': '1.0'
    };

    constructor () {
        this.axiosInstance = axios.create({
            baseURL: BASE_URL,
            headers: this.HEADERS
        })
    }

    public static getInstance(): LaravelClient
    {
        if (!LaravelClient.instance) {
            LaravelClient.instance = new LaravelClient();
        }
        return LaravelClient.instance;
    }

    public async get<T>(url: string, params?: Record<string, unknown>): Promise<T>
    {
        const res = await this.axiosInstance.get<T>(url, {params});
        return res.data;
    }
}

export default LaravelClient.getInstance();