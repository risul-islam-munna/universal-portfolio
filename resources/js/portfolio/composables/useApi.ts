import axios from 'axios';

const BASE = import.meta.env.VITE_API_BASE_URL || '/api/v1';

const api = axios.create({ baseURL: BASE });

export function useApi() {
    return {
        get: <T>(path: string) => api.get<T>(path).then((r) => r.data),
        post: <T>(path: string, data: unknown) => api.post<T>(path, data).then((r) => r.data),
    };
}
