import axios from 'axios';
import type { AxiosInstance } from 'axios';

const axiosInstance: AxiosInstance = axios.create({
  baseURL: 'https://api.example.com', // Replace with your API
  timeout: 10000,
  headers: {
    'Content-Type': 'application/json',
  },
});

// Interceptors for inspection/logging
axiosInstance.interceptors.request.use(
  (config) => {
    console.log('[Request]', config);
    return config;
  },
  (error) => {
    console.error('[Request Error]', error);
    return Promise.reject(error);
  }
);

axiosInstance.interceptors.response.use(
  (response) => {
    console.log('[Response]', response);
    return response;
  },
  (error) => {
    console.error('[Response Error]', error);
    return Promise.reject(error);
  }
);

export default {
  install: (app: any) => {
    app.config.globalProperties.$axios = axiosInstance;
  },
};

export { axiosInstance };
