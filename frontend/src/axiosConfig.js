import axios from 'axios';

axios.defaults.withCredentials = true; 
axios.defaults.withXSRFToken = true;  

// interceptor for all axios requests
axios.interceptors.request.use(
    (config) => {
        const locale = sessionStorage.getItem('locale') || 'en';
        config.headers['Accept-Language'] = locale;
        return config;
    },

    (error) => {
        return Promise.reject(error);
    }
);

export default axios;
