import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Get CSRF token from meta tag and set it as default header
let token = document.head.querySelector('meta[name="csrf-token"]') as HTMLMetaElement;

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
    
    // Also add CSRF token to all POST requests as form data
    window.axios.interceptors.request.use(function (config) {
        if (config.method === 'post' && token) {
            // Add CSRF token to form data for POST requests
            if (config.data && typeof config.data === 'object') {
                config.data._token = token.content;
            }
        }
        return config;
    });
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}
