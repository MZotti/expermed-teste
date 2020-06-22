import axios from 'axios';

const api = axios.create({
    baseUrl: 'http://127.0.0.1:8000/api/',
    headers: {'content-type': 'multipart/form-data'}
})

export default api;