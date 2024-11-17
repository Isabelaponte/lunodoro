/**
 * Generic function to configure the token interceptor
 * @param apiInstance AxiosInstance for the especific api
 */

export const configureTokenInterceptor = (apiInstance: any) => {
    apiInstance.interceptors.request.use(
        async (config: any) => {
            const token = localStorage.getItem('token');
            config.headers.Authorization = `Bearer ${token}`;
            return config;
        },
        (error: any) => {
            Promise.reject(error);
        }
    );
};