import axios from 'axios';

const basePath = process.env.VUE_APP_API_URL;
<<<<<<< HEAD

//const basePath = 'http://127.0.0.1:8000';

=======
//const basePath = 'http://127.0.0.1:8000'
>>>>>>> c8b6ebe34c092f96035659e281e3cf8e92262cae
export default axios.create({
    baseURL : basePath,
    withCredentials: true
});