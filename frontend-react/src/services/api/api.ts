import axios, { AxiosInstance } from 'axios';

const baseUrl = 'http://localhost/luno/lunodoro/';

const api: AxiosInstance = axios.create({
    baseURL: baseUrl,
});

//TODO:interceptor token

export default api;