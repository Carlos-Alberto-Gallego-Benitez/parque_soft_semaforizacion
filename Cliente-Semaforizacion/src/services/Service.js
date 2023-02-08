import axios from 'axios';

const basePath = process.env.VUE_APP_API_URL;

export default axios.create({
    baseURL : basePath,
    withCredentials: true
});