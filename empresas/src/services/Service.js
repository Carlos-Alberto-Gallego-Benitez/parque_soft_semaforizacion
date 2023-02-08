import axios from 'axios';

const basePath = process.env.VUE_APP_API_URL;

//const basePath = 'http://127.0.0.1:8000';

export default axios.create({
    baseURL : basePath,
    withCredentials: true
});